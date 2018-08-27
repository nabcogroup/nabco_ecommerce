<?php 
  
    $nbMainNavigation = Nab_MainNavigation::createInstance(array('location' => 'collection')); 

?>


<div class="row">
<?php if($nbMainNavigation->haveItems()) : ?>

<?php foreach($nbMainNavigation->items as $item) { ?>
    <div class="col-md-4 py-1 px-1">
    <?php
        $thumbnail_id = get_woocommerce_term_meta($item->object_id,'thumbnail_id',true); 
        $img_src = wp_get_attachment_image_src( $thumbnail_id,'medium' );
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


    


