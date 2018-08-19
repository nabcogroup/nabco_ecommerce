<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','');

$vid_src = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/videos/fp.mp4');

$vid_post = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/imgs/front.jpeg');

?>


 <!-- video section-->
<section class="nb-section slider-section p-0 m-0">
		<div class="ns-video-box-rel"></div>
		<div id="vidFront" class="video-wrapper">
			<video id="main-video" src="<?php echo $vid_src ?>" poster="<?php echo $vid_post ?>" autoplay muted onended="this.play()" class="videoContainer__video"></video>
		</div>	
</section>

<?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>


<?php if($under_con == 'development') : ?>
	
	<?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>

<?php endif; ?>

<!-- testimony section -->
<section class="nb-section testimony-section">
	<div class="container">
		<div class="row">
			<div class="nb-section-title-wrapper col-md-12">

				<h3 class="nb-section-title">Our Products</h3>
				
			</div>

			<div class="col-md-8">

				<?php get_template_part('template-parts/content-loop/content', 'product-collection') ?>

			</div>
			
			<div class="col-md-4">

				<?php get_template_part('template-parts/content-loop/content','testimonial') ?>

			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
	
	</div>
</section>



<?php get_footer(); ?>