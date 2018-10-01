<?php 
    
    $nbMainNavigation = Nab_MainNavigation::createInstance(array('location' => 'primary')); 

    $page_link = get_theme_mod('promotion_page_link','');
?>


<div class="d-none d-md-block">
    <nav class="nb-navbar nb-navbar-js">
        <div class="container">
            <?php if($nbMainNavigation->haveItems()) { ?>
                <ul class="nb-menu justify-content-center">
                    <?php
                        //loop
                        foreach($nbMainNavigation->items as $item) {
                            if($htmlMenu = Nab_MainNavigationHtml::createHtmlMenu($item,$nbMainNavigation->items,$nbMainNavigation)) {
                                echo $htmlMenu;
                            }
                        }
                    ?>
                    <?php echo nabcofurnitures_do_shortcode('ns-sale-text', array(
                      'wrapper_open'    =>  '<li class="nb-link" style="background:green"><a href="'. $page_link .'" class="nb-item-menu item-menu-special">',
                      'wrapper_close'   =>  '</a></li>'
                    )); ?>
                </ul>

            <?php } ?>
        </div>
    </nav>
</div>


<!-- menu will merge -->
<div class="d-block d-md-none">
    <div id="mobileMenu" class="mobile-menu py-5 menu-hide">
        <?php if(is_user_logged_in()) : ?>
            <div style="padding:25px 0;"></div>
        <?php endif ?>

        <span class="mobile-close-icon" data-target="#mobileMenu"><i class="fa fa-times-circle fa-2x"></i> </span>


      
        <!-- search navigation -->
        <?php get_template_part( 'sidebar-templates/sidebar', 'front-search' ) ?>

        <?php if($nbMainNavigation->haveItems()) : ?>
            <div class="menu-primary-container">
                <ul class="navbar-nav cust-navbar-item mr-auto">
                    <?php foreach($nbMainNavigation->items as $item) :  ?>
                        
                        <?php 
                            $subHtmls = ""; 
                            $li_css = array();
                            if($item->menu_item_parent != 0) continue;
                        ?>
                        <?php if(in_array('has_children',$item->classes)) { 
                                $li_css = array("has_children","dropdown","menu-item-has-children");
                                $subHtmls = "<ul class='dropdown-menu' aria-labeled='menu-item-{$item->ID}'>";
                                foreach($nbMainNavigation->items as $subnav) {
                                    if($subnav->menu_item_parent == $item->ID) {
                                        $subHtmls .= "<li itemscope='itemscope' itemtype='https://www.schema.org/SiteNavigationElement' id='menu-item-{$subnav->ID}' class='menu-item nav-item'>";
                                        $subHtmls .= "<a id='menu-item-{$subnav->ID}' title='{$subnav->title}' href='{$subnav->url}' class='dropdown-item'>{$subnav->title}</a>";
                                        $subHtmls .= "</li>";
                                    }
                                }
                                $subHtmls .= "</ul>";
                            }
                        ?>

                        <li itemscope="itemscope" 
                            itemtype="https://www.schema.org/SiteNavigationElement" 
                            id="menu-item-<?php echo $item->ID; ?>" 
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-763 nav-item <?php implode(" ",$li_css) ?>">
                            
                            <a 
                                id="menu-item-<?php echo $item->ID; ?>"
                                href="<?php echo $item->url; ?>" 
                                title="<?php echo $item->title; ?>" 
                                class="nav-link"><?php echo $item->title; ?></a>
                        </li>        
                    <?php endforeach; ?>
                    <?php echo nabcofurnitures_do_shortcode('ns-sale-text', array(
                      'wrapper_open'    =>  '<li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-763 nav-item"><a href="' . $page_link . '" class="nav-link">',
                      'wrapper_close'   =>  '</a></li>'
                    )); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
