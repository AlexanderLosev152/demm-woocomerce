import { defineConfig } from 'vite';
import { mkdir, readdir, stat } from 'node:fs/promises';
import os from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { Worker } from 'node:worker_threads';
import sharp from 'sharp';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const scssPath = path.resolve(__dirname, 'src/scss');

// Конвертация TTF -> WOFF2 выносится в worker_threads,
// чтобы параллельные шрифты не блокировали главный поток сборки.
const fontWorkerCode = `
	const { workerData, parentPort } = require('node:worker_threads');

	(async () => {
		const { readFile, writeFile } = await import('node:fs/promises');
		const { default: ttf2woff2 } = await import('ttf2woff2');

		const bytes = await readFile(workerData.source);
		await writeFile(workerData.output, ttf2woff2(bytes));
		parentPort.postMessage('done');
	})().catch((error) => {
		console.error(error);
		process.exit(1);
	});
`;

async function listFiles(directory) {
	const entries = await readdir(directory, { withFileTypes: true });
	const files = [];

	for (const entry of entries) {
		const fullPath = path.join(directory, entry.name);
		if (entry.isDirectory()) {
			files.push(...await listFiles(fullPath));
		} else if (entry.isFile()) {
			files.push(fullPath);
		}
	}

	return files;
}

async function ensureDirectory(directory) {
	await mkdir(directory, { recursive: true });
}

// Пропускаем файл, если результат уже собран и новее исходника.
async function isOutdated(source, output) {
	try {
		const [sourceStat, outputStat] = await Promise.all([stat(source), stat(output)]);
		return sourceStat.mtimeMs > outputStat.mtimeMs;
	} catch {
		return true;
	}
}

// Параллельный пул: sharp распределяет работу по ядрам,
// а конвертация шрифтов уходит в worker_threads.
async function runPool(items, limit, task) {
	const queue = [...items];
	const poolSize = Math.max(1, Math.min(limit, queue.length));

	await Promise.all(
		Array.from({ length: poolSize }, async () => {
			while (queue.length > 0) {
				await task(queue.shift());
			}
		}),
	);
}

function convertFontInWorker(source, output) {
	return new Promise((resolve, reject) => {
		const worker = new Worker(fontWorkerCode, {
			eval: true,
			workerData: { source, output },
		});

		worker.once('exit', (code) => {
			if (code === 0) {
				resolve();
			} else {
				reject(new Error(`Font conversion failed: ${source} (exit code ${code})`));
			}
		});
		worker.once('error', reject);
	});
}

async function processAssets(themeDirectory, addWatchFile) {
	const sourceImages = path.join(themeDirectory, 'src/images');
	const sourceFonts = path.join(themeDirectory, 'src/fonts');
	const [imageFiles, fontFiles] = await Promise.all([
		listFiles(sourceImages),
		listFiles(sourceFonts),
	]);

	addWatchFile(sourceImages);
	addWatchFile(sourceFonts);
	imageFiles.forEach(addWatchFile);
	fontFiles.forEach(addWatchFile);

	const staleImages = [];
	for (const imageFile of imageFiles) {
		const relativePath = path.relative(sourceImages, imageFile);
		const outputPath = path.join(
			themeDirectory,
			'assets/images',
			relativePath.replace(/\.[^.]+$/, '.webp'),
		);

		if (await isOutdated(imageFile, outputPath)) {
			staleImages.push([imageFile, outputPath]);
		}
	}

	await runPool(staleImages, os.availableParallelism(), async ([imageFile, outputPath]) => {
		await ensureDirectory(path.dirname(outputPath));
		await sharp(imageFile).webp().toFile(outputPath);
	});

	const staleFonts = [];
	for (const fontFile of fontFiles) {
		if (path.extname(fontFile).toLowerCase() !== '.ttf') {
			throw new Error(`Unsupported font format: ${fontFile}. Only TTF fonts can be converted to WOFF2.`);
		}

		const relativePath = path.relative(sourceFonts, fontFile);
		const outputPath = path.join(
			themeDirectory,
			'assets/fonts',
			relativePath.replace(/\.[^.]+$/, '.woff2'),
		);

		if (await isOutdated(fontFile, outputPath)) {
			staleFonts.push([fontFile, outputPath]);
		}
	}

	for (const [, outputPath] of staleFonts) {
		await ensureDirectory(path.dirname(outputPath));
	}

	if (staleFonts.length > 0) {
		await runPool(staleFonts, os.availableParallelism(), ([source, output]) => (
			convertFontInWorker(source, output)
		));
	}
}

export default defineConfig({
	root: __dirname,

	build: {
		outDir: path.resolve(__dirname, 'assets'),
		emptyOutDir: false,

		rollupOptions: {
			input: {
				main: path.resolve(__dirname, 'src/js/main.js'),
			},

			output: {
				entryFileNames: 'js/[name].min.js',

				assetFileNames: (assetInfo) => {
					if (assetInfo.name?.endsWith('.css')) {
						return 'css/style.min.[ext]';
					}

					return '[name].[ext]';
				},
			},
		},

		cssCodeSplit: false,
		minify: 'esbuild',
		sourcemap: false,
	},

	css: {
		preprocessorOptions: {
			scss: {
				loadPaths: [scssPath],
			},
		},
	},

	plugins: [
		{
			name: 'convert-theme-assets',

			apply: 'build',

			async buildStart() {
				await processAssets(__dirname, (file) => {
					this.addWatchFile(file);
				});
			},
		},
	],

	server: {
		watch: {
			usePolling: false,
		},
		hmr: false,
	},

	resolve: {
		alias: {
			'@scss': scssPath,
			'@': path.resolve(__dirname, 'assets'),
		},
	},
});
