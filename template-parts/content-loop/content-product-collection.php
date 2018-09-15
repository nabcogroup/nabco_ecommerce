<?php 

    /*
        Content Product Collection
    */
?>
<?php

  
    $nbMainNavigation = Nab_MainNavigation::createInstance(array('location' => 'collection')); 
    $renders = array();
    if($nbMainNavigation->haveItems()) {
        foreach($nbMainNavigation->items as $item) {
            
            $classes = $item->classes;
            $thumbnail_id = get_woocommerce_term_meta($item->object_id,'thumbnail_id',true); 
            $img_src = wp_get_attachment_image_src( $thumbnail_id,'full' );
            $attr = array(
                'img' => $img_src[0],
                'class' => implode(' ',$classes), 
                'title' => $item->title,
                'permalink' => $item->url);
            
            if(in_array('collection_top', $classes)) {
                $renders['top'] = $attr;
            }
            else if(in_array('collection_side',$classes)) {
                $renders['side'] = $attr;
            }
            else {
                $renders['mini'][] =   $attr;
            }
        }   
    }
?>

<div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo $renders['top']['permalink']; ?>" class="nb-anchor-wrapper">
                    <div class='<?php echo $renders['top']['class'] ?> card-product-thumbnail wow bounceInUp'>
                        <div class="shadow"></div>
                        <img src="<?php echo $renders['top']['img']; ?>" class="card-img-top"/>
                        <h3 class="card-title"><?php echo $renders['top']['title']; ?></h3>
                        <button class="nb-btn-thumnail btn-shop">Shop</button>
                    </div>
                </a>
            </div>
            <?php foreach($renders['mini'] as $render) : ?>
            <div class="col-md-6">
                    <a href="<?php echo $render['permalink']; ?>" class="nb-anchor-wrapper">
                    <div class='<?php echo implode(' ', $render['class']); ?> card-product-thumbnail wow bounceInUp'>
                        <div class="shadow"></div>
                        <img src="<?php echo $render['img']; ?>" class="card-img-top"/>
                        <h3 class="card-title"><?php echo $render['title']; ?></h3>
                        <button class="nb-btn-thumnail btn-shop">Shop</button>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

</div>

<!-- side -->
<div class="col-md-4">
    <div class='<?php echo $renders['side']['class'] ?> card-product-thumbnail wow bounceInRight'>
        <div class="shadow"></div>
        <img src="<?php echo $renders['side']['img']; ?>" class="card-img-top"/>
        <h3 class="card-title"><?php echo $renders['side']['title']; ?></h3>
        <button class="nb-btn-thumnail btn-shop">Shop</button>
    </div>
</div>


