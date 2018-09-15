<?php 

    $title = wp_kses_post(get_theme_mod('promotion_title', ''));
    $page_link = get_theme_mod('promotion_page_link','');
    $sale_approval_type = get_theme_mod('promotion_view_type','none');

    $product_sale_content = "";
    if('none' !== $sale_approval_type) {

        $args = array(
            'limit'         =>      intval(get_theme_mod('promotion_limit','7')),
            'class'         =>      get_theme_mod('promotion_css', 'front-view'),
            'on_sale'       =>      true,
            'orderby'       =>      esc_attr(get_theme_mod('promotion_orderby','date')),
            'columns'       =>      4,
        );
        
        if($sale_approval_type == 'live') {
            $product_sale_content = nabcofurnitures_do_shortcode('products',$args);
        }
        else if($sale_approval_type == 'review') {
            
            if(is_user_logged_in()) 
            {
                $product_sale_content = nabcofurnitures_do_shortcode('products',$args);
            }
        }
        else {
            
        }
    }

?>

<?php if(!empty($product_sale_content)) : ?>
<section class="nb-section full-section">
    <div class="container">
        <div class="row">
            <div class="nb-section-title-wrapper col-md-12">
                <h3 class="nb-section-title"><?php echo wp_kses_post($title); ?></h3>
            </div>

            <?php echo $product_sale_content; ?>
        </div>
        <div class="row justify-content-center my-5">
            <div class='col-md-3'>
                <?php if(!empty($page_link)) : ?>
                    <?php echo sprintf('<a href="%s" class="nb-btn nb-link-sale nb-block">%s</a>', $page_link,__('View More')); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>