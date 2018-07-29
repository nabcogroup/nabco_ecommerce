<?php 
    
    $args = array(
        'theme_location'  => 'primary',
        'menu_class'      => 'navbar-nav cust-navbar-item mr-auto',
        'fallback_cb'     => '',
        'menu_id'         => 'main-menu',
        'depth'           => 2,
        'walker'          => new WP_Bootstrap_Navwalker());
    
    $locations = get_nav_menu_locations();


    if(isset($locations['primary'])) {
        
        $menu = get_term($locations['primary'],'nav_menu');

        $items = wp_get_nav_menu_items( $menu->name ); 
        
    }
    

    add_filter( 'nb-menu-parent', 'menu_parent_create_item', 10, 2 );


    function menu_parent_create_item($item,$items) {

        $output = '';
        
        $curNavItemID = $item->ID;

        
        $childrenOutput = "";
        $cssDropdown = "";
        $anchorCssDropdown = "";
        
        if(in_array('has_children',$item->classes)) {
            
            $cssDropdown = "nb-dropdown";
            $anchorCssDropdown = "nb-dropdown-toggle";
            
            $childrenOutput .= "<div class='nb-dropdown__wrapper'>";
            $childrenOutput .= "<div class='container row p-1 m-0'>";
            $childrenOutput .= "<div class='col-4'>";
            $childrenOutput .= "<ul class='nb-dropdown-subnav' data-group='{$item->ID}'>";
            
            $imageHtmls = [];
            $childrenList = "";
            $isActive = true;
            foreach($items as $subnav) {

                if ( $subnav->menu_item_parent == $curNavItemID) {
                    
                    $thumbnail_id = get_woocommerce_term_meta($subnav->object_id,'thumbnail_id',true);
                    $image = wp_get_attachment_url( $thumbnail_id );
                    
                    array_push($imageHtmls, "<img src='{$image}' alt='{$subnav->title}' />");

                    $childrenList .= "<li class='js-subnav-icon nb-category-subnav {$item->ID} ". ($isActive ? 'active' : '') . "' data-src='{$image}'>";
                    $childrenList .= "<a href='{$subnav->url}'>{$subnav->title}</a>";
                    $childrenList .= "</li>";

                    $isActive = false;
                }

               
                
            }

            
            $childrenOutput .= "{$childrenList}</ul>";
            $childrenOutput .= "</div>";
            $childrenOutput .= "<div class='col-8'>";
            $childrenOutput .= "<div class='nb-dropdown-img-container'>";
            $childrenOutput .= "<img src='' id='subnavContainer-{$item->ID}' >";
            $childrenOutput .= "<div>";
            $childrenOutput .= "</div>";

            $childrenOutput .= "</div>";
            $childrenOutput .= "</div>";

        }
        
        // get the custom classes for the item
        // (determined within the WordPress Appearance > Menu section)
        $classes = implode(" ",$item->classes);


        $anchor = "<a class='nb-item-menu {$anchorCssDropdown}'  href='{$item->url}'>{$item->title}</a>";

        $output = "<li class='nb-link {$classes} {$cssDropdown}'>  {$anchor} {$childrenOutput}  </li>";

        return $output;
    }

?>

<div class="d-none d-md-block">
    <nav class="nb-navbar">
        <div class="container">
            
           
            <?php if(count($items) > 0) : ?>
                <ul class="nb-menu justify-content-center">
                    <?php $output = ""; ?>

                    <?php foreach($items as $item) : ?>

                        <?php if($item->menu_item_parent != 0) { continue; } ?>
                        
                        <?php  /* create display list*/ ?>
                        
                        <?php $output = apply_filters( 'nb-menu-parent', $item, $items ) ?>

                        <?php echo $output; ?>

                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
</div>


<!-- menu will merge -->
<div class="d-block d-md-none">
    <div id="mobileMenu" class="mobile-menu py-5 menu-hide">
        <?php if(is_user_logged_in()) : ?>
            <div style="padding:25px 0;"></div>
        <?php endif ?>
        <span class="mobile-close-icon" data-target="#mobileMenu"><i class="far fa-times-circle fa-2x"></i> </span>
        <?php get_template_part( 'template-parts/search/search', 'form' ) ?>
        
        <!-- The WordPress Menu goes here -->
        <?php wp_nav_menu($args); ?>
    </div>
</div>
</div>
