<?php 

    $args = array(
        'taxonomy'  =>  'product_cat',
        'hierarchical' => 0,
        'hide_empty'   => 1
    );

    $categories = get_categories(apply_filters('nb-product-collection-loop-args', $args));

?>



<div class="row">
<?php foreach($categories as $category) { ?>
    
    <div class="col-md-4 px-0">

    <?php

        $thumbnail_id = get_woocommerce_term_meta($category->term_id,'thumbnail_id',true); 

        $img_src = wp_get_attachment_image_src( $thumbnail_id,'large' );
        
        $name = $category->name;

        $category_link = get_category_link($category);
        
        
    ?>
    
    <div class="card card-product-collection">
        <div class="card-img-wrapper">
            <div class="card-product-shadow"></div>
            <img src="<?php echo $img_src[0] ?>" alt="" class="card-top-img" >
            <a href="<?php echo $category_link;  ?>" class="card-product-shop-link">SHOP</a>
        </div>
        <div class="card-title">
            <?php echo sprintf(' %s %s ', $name, __('Collection')); ?>
        </div>

    </div>
    </div>
<?php } ?>
</div>


    


