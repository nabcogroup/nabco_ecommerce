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
            $product_sale_content = nabcofurnitures_do_shortcode('nb_sale_products',$args);
        }
        else if($sale_approval_type == 'review') {
            if(is_user_logged_in()) 
            {
                $product_sale_content = nabcofurnitures_do_shortcode('nb_sale_products',$args);
            }
        }
        else {
            
        }
    }

?>

<?php if(!empty($product_sale_content)) : ?>
<section class="site-wide-section site-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="site-section-header-2"><span><?php echo wp_kses_post($title); ?></span></h3>
            </div>
        </div>    
        <?php echo $product_sale_content; ?>
        <div class="row justify-content-center my-5">
            <div class='col-md-3'>
                <?php if(!empty($page_link)) : ?>
                    <?php echo sprintf('<a href="%s" class="btn-link-sale" style="display:block;text-align:center">%s</a>', $page_link,__('View More')); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>