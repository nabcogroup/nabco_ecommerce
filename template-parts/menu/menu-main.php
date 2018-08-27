<?php 
    
  
    $nbMainNavigation = Nab_MainNavigation::createInstance(array('location' => 'primary')); 
    
    if(! function_exists('menu_parent_create_item')) {

        function menu_parent_create_item( $item, $items) {

            $output = '';
            
            $curNavItemID = $item->ID;
            
            $childrenOutput = "";
            $cssDropdown = "";
            $anchorCssDropdown = "";
            
            if(in_array('has_children',$item->classes)) {
                
                $cssDropdown = "nb-dropdown";
                $anchorCssDropdown = "nb-dropdown-toggle";
                
                $childrenOutput .= "<div class='nb-dropdown__wrapper'>";
                $childrenOutput .= "<div class='container row m-0 full-container'>";
                $childrenOutput .= "<div class='col-4 m-0 p-0'>";
                $childrenOutput .= "<ul class='nb-dropdown-subnav' data-group='{$item->ID}'>";
                
                $imageHtmls = [];
                $childrenList = "";
                $isActive = true;   
                $productArgs = [];
                
                foreach($items as $subnav) {
                    //subnavigation
                    if ( $subnav->menu_item_parent == $curNavItemID) {
                        
                        $thumbnail_id = get_woocommerce_term_meta($subnav->object_id,'thumbnail_id',true);
                        
                        $image = wp_get_attachment_image_src($thumbnail_id,'medium' );
                        
                        $imageHtmls[$subnav->object_id] = "<img src='{$image[0]}' alt='{$subnav->title}' class='nb-wc-product-feature' />";

                        $childrenList .= "<li class='js-subnav-icon nb-category-subnav {$item->ID} ". ($isActive ? 'active' : '') . "' data-container='product_catkey_{$subnav->object_id}'>";
                        $childrenList .= "<a href='{$subnav->url}'>{$subnav->title}</a>";
                        $childrenList .= "</li>";

                        $args = array(
                            'post_type'             => array('product','product_variation'),
                            'post_status'           => 'publish',
                            'posts_per_page'         =>  5,
                            'tax_query'             => array(
                                array(
                                    'taxonomy'  => 'product_cat',
                                    'field'     => 'term_id', 
                                    'terms'     => $subnav->object_id
                                ),
                            )
                        );
                        
                        $productArgs[$subnav->object_id] = apply_filters('nb_menu_subnavigation_loop_args',$args); 
                        
                        //one time activation
                        if($isActive) $isActive = false;
                    }
                }

                
                
                
                $childrenOutput .= "{$childrenList}</ul>";
                $childrenOutput .= "</div><!-- col -->";
                
                $childrenOutput .= "<div class='col-8 p-0 m-0'>";
                $childrenOutput .= "<div class='nb-dropdown-container'>";
                $childrenOutput .=  apply_filters( 'products_list_args',$productArgs,$imageHtmls);
                $childrenOutput .= "</div>";
                $childrenOutput .= "</div>";

                $childrenOutput .= "</div><!-- container -->";
                $childrenOutput .= "</div><!-- wrapper -->";

            }
            
            // get the custom classes for the item
            // (determined within the WordPress Appearance > Menu section)
            $classes = implode(" ",$item->classes);


            $anchor = "<a class='nb-item-menu {$anchorCssDropdown}'  href='{$item->url}'>{$item->title}</a>";

            $output = "<li class='nb-link {$classes} {$cssDropdown}'>  {$anchor} {$childrenOutput}  </li>";

            return $output;
        }
    }

?>


<div class="d-none d-md-block">
<?php 

$args = array(
    'theme_location'  => 'primary',
    'menu_class'      => 'navbar-nav cust-navbar-item mr-auto',
    'fallback_cb'     => '',
    'menu_id'         => 'main-menu',
    'depth'           => 2,
    'walker'          => new WP_Bootstrap_Navwalker());
?>
    <nav class="nb-navbar">
        <div class="container">
            <?php if($nbMainNavigation->haveItems()) { ?>
                <ul class="nb-menu justify-content-center">
                    <?php
                        //loop
                        foreach($nbMainNavigation->items as $item) {
                            if($htmlMenu = Nab_MainNavigationHtml::createHtmlMenu($item,$nbMainNavigation->items)) {
                                echo $htmlMenu;
                            }
                        }
                    ?>

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


        <!-- -->
        <div class="nb-tran-icon">
            <!-- carting here -->
            <?php 
                //hooked: nabco_furnitures_cart_link_display - 10
                do_action('nabco_furnitures_header_display_fragment'); 
            ?>
        </div>
        <!-- search navigation -->
        <?php get_template_part( 'sidebar-templates/sidebar', 'front-search' ) ?>



        <?php if($nbMainNavigation->haveItems()) : ?>
            <div class="menu-primary-container">
                <ul class="navbar-nav cust-navbar-item mr-auto">
                    <?php foreach($nbMainNavigation->items as $item) :  ?>
                        <?php 
                            $subHtmls = ""; 
                            $li_css = array();
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

                            <!-- Sub Menu  -->
                            <?php echo $subHtmls; ?>
                            <!-- end submenu -->
                        </li>        
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
