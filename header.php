<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nabcofurn_us
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
   <?php do_action('nabco_furnitures_style'); ?>
</head>
<body <?php body_class(); ?>>
    <!-- preloading -->
    <?php 

        if('false' == intval(get_theme_mod('nb_theme_debug','false'))) {
            /************** 
             * Hook: nabco_furniture_before_content
             * 
             * @hooked: nabco_furniture_pre_loading - 10
            */
            do_action('nabco_furniture_before_content'); 
        }
       
    ?>
    <!-- ******************* The Header Area ******************* -->
    <header id="main-header">
        <div class="navbar navbar-expand-md navbar-light nb-header">
            <div class="container">
                <!-- Your site title as branding in the menu -->
                <?php 
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    /** 
                     * Hooked: 
                     *      nabcofurniture_get_logo - 10
                    */
                    echo apply_filters('nabcofurniture_the_logo', array(
                        'custom_logo_id' => get_theme_mod('custom_logo'),
                        'link'  =>  home_url('/'),
                        'size'  =>  'full'
                    ));
                ?>

                <div class="collapse navbar-collapse">
                    <div class="row" style="width:100%">
                        <div class="col-md-4">
                            <?php 
                                if(get_theme_mod('nb_header_social_api','none') == 'basic') {
                                    get_template_part( 'sidebar-templates/sidebar', 'social' ); 
                                }
                            ?>
                        </div>
                        <div class="col-md-8">
                            <?php  
                                /** 
                                * Hooked: 
                                *  nabcofurniture_get_product_search - 10
                                */
                                do_action('nabcofurniture_on_header_loop')
                            ?>
                        </div>
                    </div>
                </div>

                <div class="nb-tran-icon">
                    <!-- carting here -->
                    <?php 
                        //hooked: nabco_furnitures_cart_link_display - 10
                        //hooked: nabco_furnitures_woocommerce_customer_account - 20
                        do_action('nabcofurniture_header_display_fragment'); 
                    ?>
                </div>
                
                <button class="navbar-toggler" type="button" 
                            data-toggle="collapse" 
                            data-target="#mobileMenu" 
                            aria-controls="navbarSupportedContent" 
                            aria-expanded="false" aria-label="Toggle navigation">
                        
                            <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
        
        <!-- announcement -->
        <?php echo nabcofurnitures_do_shortcode('ns-announcement',array('classes' => array('text-center'))); ?>

	</header> <!-- END OF HEADER -->
	
	<main class="main-wrapper">

    <!-- top header -->
    <?php if(!is_front_page()) : ?> 

        <div class="header-menu-wrapper">
            <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
        </div>
        
        <?php
        
        if(get_theme_mod('nb_underconstruction', 'full_prod') == 'development') {
            if(get_theme_mod('nb_uc_cover', 'all') == 'wc') {
                if(is_woocommerce() || is_account_page()) {
                    //check if underconstruction
                    get_template_part('template-parts/content-loop/content', 'under-construction');
                    get_footer();
                    exit;
                }
            }    
            else {
                //check if underconstruction
                get_template_part('template-parts/content-loop/content', 'under-construction');
                get_footer();
                exit;
            }
        }
        ?>
        <!-- opening container -->
        <div class="container">
            <?php
                if(is_page('checkout'))  {
                    echo '<div class="row col-md-12 my-3" >';
                    echo sprintf("<a href='/cart' class='nb-wc-cart-breadcrumbs'> <i class='fa fa-mail-reply'></i> %s</a>",__("Back to Cart")); 
                    echo '</div>';
                }
                else {
                    // hooked: woocommerce_breadcrumb
                    do_action('nabco_furniture_before_page_loop');
                }
            ?><?php endif; ?>