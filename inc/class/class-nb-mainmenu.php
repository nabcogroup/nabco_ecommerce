<?php

class Nab_MainNavigation {

    private static $instance = null;
    public $items = array();
    
    public static function createInstance($args = array()) {
        if($instance == null) {
            static::$instance = new static($args);
        }

        return static::$instance;
    }

    public function __construct($args = array()) {

        $locations = get_nav_menu_locations();

        if(isset($locations[$args['location']])) {
            
            $menu = get_term($locations[$args['location']],'nav_menu');
            
            $this->items = wp_get_nav_menu_items( $menu->name );
        }
    }

    public function haveItems() {
        return count($this->items) > 0 ? true : false;
    }


}

class Nab_MainNavigationHtml {

    public static function createHtmlMenu(&$item,&$items) {
        
        if($item->menu_item_parent != 0) return false;
        
        $cssDropdown = "";
        $anchorCssDropdown = "";
        if(in_array('has_children',$item->classes)) {
            $cssDropdown = "nb-dropdown";
            $anchorCssDropdown = "nb-dropdown-toggle";
            $childrenOutput = static::createHtmlSubMenu($item->ID, $items);
        }

        $anchor = "<a class='nb-item-menu {$anchorCssDropdown}'  href='{$item->url}'>{$item->title}</a>";
        $output = "<li class='nb-link {$classes} {$cssDropdown}'>  {$anchor} {$childrenOutput}  </li>";

        return $output;
    }

    


    public static function createHtmlSubMenu($id, &$items) {
        
        $imageHtmls = [];
        
        $childrenOutput = "<!--children wrapper --><div class='nb-dropdown__wrapper'>";
        $childrenOutput .= "<div class='container row m-0 full-container'>";
        $childrenOutput .= "<!-- submenu --><div class='col-4 m-0 p-0'>";
        $childrenOutput .= "<!-- list opening --><ul class='nb-dropdown-subnav' data-group='{$id}'>";
        
        $imageHtmls = array();
        $productArgs = array();
        $isActive = true;   
        
        $childrenList = "";
        foreach($items as $subnav) {
            //subnavigation
            if ( $subnav->menu_item_parent == $id) {
                $image = wp_get_attachment_image_src(get_woocommerce_term_meta($subnav->object_id,'thumbnail_id',true),'medium' );
                $imageHtmls[$subnav->object_id] = array(
                       "title"  =>  $subnav->title,
                       "image"  =>  "<img src='{$image[0]}' alt='{$subnav->title}' class='nb-wc-product-feature' />"
                );

                $childrenList .= "<li class='js-subnav-icon nb-category-subnav {$id} ". ($isActive ? 'active' : '') . "' data-container='product_catkey_{$subnav->object_id}'>";
                $childrenList .= "<a href='{$subnav->url}'>{$subnav->title}</a>";
                $childrenList .= "</li>";
                
                //one time activation
                if($isActive) $isActive = false;
            }
        }

        $childrenOutput .= "{$childrenList}</ul><!-- end of list -->";
        $childrenOutput .= "</div><!-- end of submenu -->";
        
        $childrenOutput .= "<div class='col-8 p-0 m-0'>";
        $childrenOutput .= "<div class='nb-dropdown-container'>";
        
        $childrenOutput .=  static::createImageList($imageHtmls);
        
        $childrenOutput .= "</div>";
        $childrenOutput .= "</div>";
        $childrenOutput .= "</div><!-- container -->";
        $childrenOutput .= "</div><!-- wrapper -->";

        return $childrenOutput;

    }

    public static function createImageList($imageArgs) {

        $html = "<!-- product wrapper --> <div class='nb-wc-product-menu-wrapper'>";
        
        foreach($imageArgs as $key => $image) {
            $html .= "<nav id='product_catkey_{$key}' class='nb-wc-menu-product category-{$key}'>"; 
            $html .= "<!-- row --><div class='row'>";
            $html .= "<!-- image column --><div class='col-md-12'><p class='nb-text-title'>{$image['title']} Collection</p> {$image['image']}</div>";
            $html .= "</div><!-- end row-->";
            $html .= "</nav>";
        }
        
        $html .= "</div><!--end -->";
        
	    return $html;
    }
}