<?php 
	$enabled = get_theme_mod('testimony_enabled','enabled');
    $image_path = get_theme_mod('testimony_background', '' );
	$args= array();
	
	if($enabled == 'enabled') :
?>

<section class="nb-section testimony-section" 
	<?php if(!empty($image_path)) : ?>
		style="background: url(<?php echo $image_path; ?>) top left no-repeat;background-size:cover;"
	<?php endif; ?>
>
	<div class="container">
		<div class="row">
			<?php echo nabcofurnitures_do_shortcode('tesm-card',$args); ?>
		</div>
	</div>
</section>

<?php endif; ?>