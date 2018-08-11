<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','');

$vid_src = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/videos/fp.mp4');

$vid_post = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/imgs/front.jpeg');

?>


 <!-- video section-->
<section class="nb-section p-0 m-0">
	<div class="slider-section">
		<div class="ns-video-box-rel"></div>
		<div id="vidFront" class="video-wrapper">
			<video id="main-video" src="<?php echo $vid_src ?>" poster="<?php echo $vid_post ?>" autoplay muted onended="this.play()" class="videoContainer__video"></video>
		</div>	
	</div>
	
	<?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>

</section>


<?php if($under_con == 'development') : ?>
    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
<?php endif; ?>

<?php get_footer(); ?>