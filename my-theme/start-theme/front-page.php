<?php

/*
Template Name: Front-page
Template Post Type: post, page, product
*/

get_header();
?>

<main class="site-main">

	<?php
	get_template_part( 'parts/hero/hero' );
	get_template_part( 'parts/categories/categories' );
	get_template_part( 'parts/promo/promo' );
	get_template_part( 'parts/about/about' );
	get_template_part( 'parts/contact/contact' );
	?>

</main>

<?php get_footer(); ?>

