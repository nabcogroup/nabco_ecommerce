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
    
        do_action('nabco_furniture_before_content'); 
    ?>

    <!-- ******************* The Header Area ******************* -->
    <header id="main-header">
        <div class="navbar navbar-expand-md navbar-light nb-header">
            <div class="container">
                <!-- Your site title as branding in the menu -->
                <?php if ( ! has_custom_logo() ) : ?>     
                    <?php if(is_front_page() && is_home()) : ?>
                        <a class="navbar-brand" href="#"><?php bloginfo('name'); ?></a>
                    <?php endif ?>

                <?php else : ?>
                    <?php 
                        $logo_id = get_theme_mod('custom_logo');
                        $image = wp_get_attachment_image_src( $logo_id , 'full' );
                    ?>
                    <a class="navbar-brand mr-auto" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $image[0]; ?>" alt=""></a>
                <?php endif; ?>
                
                <button class="navbar-toggler" type="button" 
                        data-toggle="collapse" 
                        data-target="#mobileMenu" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    
                        <span class="navbar-toggler-icon"></span>

                </button>
                
                <div class="collapse navbar-collapse">
                    <div class="row mr-auto pl-5">
                        <?php get_template_part( 'sidebar-templates/sidebar', 'social' ) ?>
                    </div>
                    <div class="row ml-auto">
                        <?php get_template_part( 'template-parts/search/search', 'form' ) ?>
                        <div class="nb-tran-icon">
                            <!-- carting here -->
                            <a href="#"> <i class="fa fa-heart"></i></a>
                            <a href="#"> <i class="fa fa-shopping-cart"></i></a>
                            <a href="#"> <i class="fa fa-user"></i></a>
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
    <?php else : ?>
        
    <?php endif; ?>