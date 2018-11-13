<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','');
$vid_src = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/videos/fp.mp4');
$vid_post = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/imgs/front.jpeg');



//<video id="main-video" src=" echo $vid_src" poster="echo $vid_post " autoplay muted onended="this.play()" class="videoContainer__video"></video>

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