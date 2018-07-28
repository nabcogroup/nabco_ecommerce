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
    
    <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
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
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobileMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse">
                    <div class="row ml-auto">
                        <?php get_template_part( 'template-parts/search/search', 'form' ) ?>
                        
                        <?php get_template_part( 'sidebar-templates/sidebar', 'social' ) ?>
                    </div>
                </div>
            </div>
        </div>
	</header>
	
	<main class="main-wrapper">
        
        <?php if(is_front_page()): ?>
            <!-- video section-->
            <section class="nb-section p-0 m-0">    
            <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '100%',
			'height', '400',
			'src', 'imgs/MAIN', 
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'Untitled-1',
			'bgcolor', '#ffffff',
			'name', 'MAIN',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'movie', '<?php echo get_template_directory_uri() ?>/imgs/MAIN',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="550" height="400" id="Untitled-1" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="<?php  echo get_template_directory() ?>/imgs/MAIN.swf ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	
	<embed src="<?php echo get_template_directory() ?>/imgs/MAIN.swf" quality="high" bgcolor="#ffffff" width="1903" height="733" name="MAIN.swf" align="middle" 
	allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" 
	pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
                <!-- <div class="video-section">
                        <iframe class="video" src="https://www.youtube.com/embed/DPbnxTQpuBU?rel=0&amp;" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div> -->

                <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
                
            </section>
        <?php elseif(is_page()) : ?>
            <?php  if(have_posts()) : the_post(); ?>
            <div class="top-page-header">
                <?php the_title('<h1 class="page-title">','</h1>') ?>
                <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
            </div>
            <?php 
                rewind_posts();
                endif;
            ?>
        <?php else : ?>
        <?php endif; ?>