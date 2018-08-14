<?php 
    
  
    
    $locations = get_nav_menu_locations();


    if(isset($locations['primary'])) {
        
        $menu = get_term($locations['primary'],'nav_menu');

        $items = wp_get_nav_menu_items( $menu->name ); 
        
    }
    
    add_filter( 'nb-main-menu', 'menu_parent_create_item', 10, 2 );

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
                        
                        $image = wp_get_attachment_url( $thumbnail_id );
                        
                        $imageHtmls[$subnav->object_id] = "<img src='{$image}' alt='{$subnav->title}' class='nb-wc-product-feature' />";

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
            <?php if(count($items) > 0) { ?>
                <ul class="nb-menu justify-content-center">
                    <?php $output = ""; ?>

                    <?php foreach($items as $item) { ?>
                        <?php if($item->menu_item_parent != 0) { continue; } ?>
                        <?php  /* create display list*/ ?>
                        <?php echo apply_filters( 'nb-main-menu', $item, $items ); ?>
                    <?php } ?>
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
        <?php get_template_part( 'template-parts/search/search', 'form' ) ?>
        
        <!-- The WordPress Menu goes here -->
        <?php wp_nav_menu($args); ?>
    </div>
</div>
</div>
