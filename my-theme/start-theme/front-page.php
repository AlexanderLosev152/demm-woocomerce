<?php

/*
Template Name: front

*/

get_header();
?>

<main class="site-main">

	<?php

	if (have_posts()) :
		while (have_posts()) : the_post();
			the_content();
		endwhile;
	endif;

	get_template_part('parts/hero/hero');
	get_template_part('parts/categories/categories');
	get_template_part('parts/promo/promo');
	get_template_part('parts/about/about');
	get_template_part('parts/contact/contact');
	?>

</main>

<?php get_footer(); ?>

