<?php 
    $args = array(
        'theme_location'  => 'primary',
        'menu_class'      => 'navbar-nav cust-navbar-item mr-auto',
        'fallback_cb'     => '',
        'menu_id'         => 'main-menu',
        'depth'           => 2,
        'walker'          => new WP_Bootstrap_Navwalker());
?>
<div class="d-none d-md-block">
    <nav class="bg-dark navbar-expand-sm navbar nb-menu">
        <!-- Menu -->
        <div id="nbNavbar" class='collapse navbar-collapse justify-content-center'>
            <!-- The WordPress Menu goes here -->
            <?php wp_nav_menu($args); ?>
        </div>
    </nav>
</div>


<!-- menu will merge -->
<div class="d-block d-md-none">
    <div id="mobileMenu" class="mobile-menu py-5 menu-hide">
        <?php if(is_user_logged_in()) : ?>
            <div style="padding:25px 0;"></div>
        <?php endif ?>
        <span class="close-icon" data-target="#mobileMenu"><i class="far fa-times-circle fa-2x"></i> </span>
        <?php get_template_part( 'template-parts/search/search', 'form' ) ?>
        
        <!-- The WordPress Menu goes here -->
        <?php wp_nav_menu($args); ?>
    </div>
</div>
</div>
