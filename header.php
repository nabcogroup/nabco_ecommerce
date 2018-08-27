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

?>
<!DOCTYPE html>
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

        /************** 
         * Hook: nabco_furniture_before_content
         * 
         * @hooked: nabco_furniture_pre_loading - 10
        */

        if( get_theme_mod('nb_theme_debug','false') == 'false') {
            do_action('nabco_furniture_before_content'); 
        }
    ?>

    <!-- ******************* The Header Area ******************* -->
    <header id="main-header">
        <div class="navbar navbar-expand-md navbar-light nb-header">
            <div class="container">
                <!-- Your site title as branding in the menu -->
                <?php 
                    $logo_path = get_theme_mod('nb_header_logo');
                ?>
                <a class="navbar-brand mr-auto" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $logo_path; ?>" alt=""></a>
                
                <button class="navbar-toggler" type="button" 
                        data-toggle="collapse" 
                        data-target="#mobileMenu" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    
                        <span class="navbar-toggler-icon"></span>

                </button>
                
                <div class="collapse navbar-collapse">
                    <div class="row mr-auto pl-5">
                        <?php 
                            if(get_theme_mod('nb_header_social_api','none') == 'basic') {
                                get_template_part( 'sidebar-templates/sidebar', 'social' ); 
                            }
                        ?>
                    </div>
                    <div class="row ml-auto">
                        <?php get_template_part( 'sidebar-templates/sidebar', 'front-search' ) ?>
                        <div class="nb-tran-icon">
                            <!-- carting here -->
                            <?php 
                                //hooked: nabco_furnitures_cart_link_display - 10
                                do_action('nabco_furnitures_header_display_fragment'); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-section-wrapper d-none d-md-block">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>  
	</header>
	
	<main class="main-wrapper">

    <!-- top header -->
    <?php if(!is_front_page()) : ?> 
        
        <div class="header-menu-wrapper">
            <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
        </div>
        <?php
        //check if underconstruction
        if(get_theme_mod('nb_underconstruction', 'full_prod') == 'development') {
            
            get_template_part('template-parts/content-loop/content', 'under-construction');

            get_footer();
            
            exit;
        }?>

        <div class="container">
            <div class="row col-md-12 my-3" >
                <?php 
                    if(is_page('checkout'))  {
                        echo sprintf("<a href='/cart' class='nb-wc-cart-breadcrumbs'> <i class='fa fa-mail-reply'></i> %s</a>",__("Back to Cart")); 
                    }
                ?>
            </div>
        </div>

    <?php else : ?>

    <?php endif; ?>