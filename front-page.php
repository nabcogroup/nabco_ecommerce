<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','');
$vid_src = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/videos/fp.mp4');
$vid_post = get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/imgs/front.jpeg');



//<video id="main-video" src=" echo $vid_src" poster="echo $vid_post " autoplay muted onended="this.play()" class="videoContainer__video"></video>

?>


<!-- video section-->
<section class="nb-section slider-section p-0 m-0">
		<?php 
			if(function_exists('nabcosetting_slider')) {
				nabcosetting_slider(); 
			}
		?>
</section>

<?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>

<?php if($under_con == 'development') : ?>
	
	<?php 
		
		get_template_part( 'template-parts/content-loop/content', 'under-construction' );

		get_footer();

		exit;
		
	?>
	
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
				<?php get_template_part('sidebar-templates/sidebar','front-page') ?>
			</div>
		</div>
	</div>
</section>



<?php get_footer(); ?>