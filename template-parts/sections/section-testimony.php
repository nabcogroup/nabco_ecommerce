<?php 
    $image_path = get_theme_mod('testimony_background', '' );
    $args= array();
?>

<section class="nb-section testimony-section" 
	<?php if(!empty($image_path)) : ?>
		style="background: url(<?php echo $image_path; ?>) top left no-repeat;bacground-size:100%;"
	<?php endif; ?>
>
	<div class="container">
		<div class="row">
			<?php echo nabcofurnitures_do_shortcode('tesm-card',$args); ?>
		</div>
	</div>
</section>