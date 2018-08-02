<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','')
?>


 <!-- video section-->
 <section class="nb-section p-0 m-0">
	<div class="slider-section">
		<div class="ns-video-box-rel"></div>
		<div class="video-wrapper">
			<video  src="<?php echo get_template_directory_uri()  ?>/dist/videos/MAIN_2.mp4" autoplay loop preload muted height="auto" width="auto">
			</video>
		</div>	
	</div>
    <!-- <div class="video-section">
            <iframe class="video" src="https://www.youtube.com/embed/DPbnxTQpuBU?rel=0&amp;" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	</div> -->
			
    <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
</section>


<?php if($under_con == 'development') : ?>
    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
<?php endif; ?>

<?php get_footer(); ?>