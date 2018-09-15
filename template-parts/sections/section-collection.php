<?php

    $title = get_theme_mod('nb_promotion_title', 'Our Collection');

?>

<!-- product collection section -->
<section class="nb-section collection-section">
	<div class="container">
		<div class="row">
			<div class="nb-section-title-wrapper col-md-12">
				<h3 class="nb-section-title"><?php echo wp_kses_post($title); ?></h3>
            </div>
            <?php 
                /** 
                 * @Hooked: nabcofurnitures_collection_navigation 
                 * **/
                do_action('product-collection-loop'); 
            ?>
		</div>
	</div>
</section>