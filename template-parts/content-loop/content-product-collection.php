<?php 

    // $args = array(
    //     'taxonomy'  =>  'product_cat',
    //     'hierarchical' => 0,
    //     'hide_empty'   => 1
    // );

    // $categories = get_categories(apply_filters('nb-product-collection-loop-args', $args));


    $locations = get_nav_menu_locations();

    $items = array();
    if(isset($locations['collection'])) {
        $menu = get_term($locations['collection'],'nav_menu');
        $items = wp_get_nav_menu_items( $menu->name ); 
    }

?>



<div class="row">
<?php if(is_array($items) && count($items) > 0) : ?>

<?php foreach($items as $item) { ?>
    
    <div class="col-md-6 px-0">

    <?php

        $thumbnail_id = get_woocommerce_term_meta($item->object_id,'thumbnail_id',true); 

        $img_src = wp_get_attachment_image_src( $thumbnail_id,'large' );
        
        $name = $item->title;

        $category_link = $item->url;
        
        
    ?>
    
    <div class="card card-product-collection">
        <div class="card-img-wrapper">
            <div class="card-product-shadow"></div>
            <img src="<?php echo $img_src[0] ?>" alt="" class="card-top-img" >
            <a href="<?php echo $category_link;  ?>" class="card-product-shop-link">SHOP</a>
        </div>
        <div class="card-title">
            <?php echo sprintf('<span> %s %s </span>', $name, __('Collection')); ?>
        </div>

    </div>
    </div>
<?php } ?>
<?php endif; ?>
</div>


    


