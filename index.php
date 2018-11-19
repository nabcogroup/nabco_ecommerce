<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','');

?>


<!-- video section-->
<?php get_template_part('template-parts/sections/section', 'video'); ?>

<?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>

<?php if($under_con == 'development') : ?>
	<?php 
		if(get_theme_mod('nb_uc_cover') == 'wc_fr' || get_theme_mod('nb_uc_cover') == 'all') {
			get_template_part( 'template-parts/content-loop/content', 'under-construction' );
			get_footer();
			exit;
		}
	?>
<?php endif; ?>

<!-- promotion collection section -->

<?php
	get_template_part('template-parts/sections/section','promotion') 
?>

<!-- product collection section -->
<?php get_template_part('template-parts/sections/section','collection') ?>

<!-- testimony section -->
<?php get_template_part('template-parts/sections/section','testimony') ?>

<?php get_footer(); ?>