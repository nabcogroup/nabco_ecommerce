<?php

class Nab_MainNavigation {
    
    public $items = array();
    
    public static function createInstance($args = array()) {
       return new Nab_MainNavigation($args);
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

    public function getProducts($id) {
        
        $args = array(
            'post_type'             => array('product','product_variation'),
            'post_status'           => 'publish',
            'posts_per_page'         =>  7,
            'tax_query'             => array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'term_id', 
                    'terms'     => $id
                ),
            )
        );
        
        $theProducts = new WP_Query($args);
        
        $productArgs = [];
        
        if($theProducts->have_posts()) {

            while($theProducts->have_posts()) {
                $theProducts->the_post();
                $productArg = array(
                    'permalink' =>  get_the_permalink(),
                    'title'     =>  get_the_title()
                );
                //get the product information
                array_push($productArgs,$productArg);
            }
        }
        
        wp_reset_postdata();
    
        return $productArgs;
    }


}

class Nab_MainNavigationHtml {

    public static function createHtmlMenu(&$item,&$items,&$navObject) {
        
        if($item->menu_item_parent != 0) return false;
        
        $cssDropdown = "";
        $anchorCssDropdown = "";
        $childrenOutput = "";
        $classes = "";
        
        if(in_array('has_children',$item->classes)) {
            $cssDropdown = "nb-dropdown";
            $anchorCssDropdown = "nb-dropdown-toggle";
            $childrenOutput = static::createHtmlSubMenu($item->ID, $items,$navObject);
            $classes = implode(" ",$item->classes);
        }

        $anchor = "<a class='nb-item-menu {$anchorCssDropdown}'  href='{$item->url}'>{$item->title}</a>";
        $output = "<li class='nb-link {$classes} {$cssDropdown}'>  {$anchor} {$childrenOutput}  </li>";

        return $output;
    }

    


    public static function createHtmlSubMenu($id, &$items,&$navObject) {
        
        $imageHtmls = [];
        
        $childrenOutput = "<!--children wrapper --><div class='nb-dropdown__wrapper'>";
        $childrenOutput .= "<div class='container row m-0 p-0 full-container'>";
        $childrenOutput .= "<!-- submenu --><div class='col-4 m-0 p-0'>";
        $childrenOutput .= "<!-- list opening --><ul class='nb-dropdown-subnav' data-group='{$id}'>";
        
        $imageHtmls = array();
        $productArgs = array();
        $isActive = true;   
        
        $childrenList = "";
        foreach($items as $subnav) {
            //subnavigation
            if ( $subnav->menu_item_parent == $id) {

                $images = wp_get_attachment_image_src(get_woocommerce_term_meta($subnav->object_id,'thumbnail_id',true),'medium' );
                
                

                $style = "";
                $classes = "";
                //load icons 
                if(count($subnav->classes) > 0) {
                    $url = get_template_directory_uri() . '/dist/imgs/icons/' . $subnav->classes[0] . '.png';
                    $style = "background:url({$url}) 5% 50% no-repeat;";
                    $classes = implode(" ", $subnav->classes);
                }


                //get sub children
                $subChild = array();
                if(in_array('sub_children', $subnav->classes)) {
                    
                    //get the sub children
                    foreach($items as $subChildNav) {
                        if($subChildNav->menu_item_parent == $subnav->ID) {
                            
                            $subChild[] = array(
                                "title"      =>  $subChildNav->title,
                                "url"        =>  $subChildNav->url,
                            );
                        }
                    }
                    
                }
                

                $imageArgs[$subnav->object_id] = array(
                    "title"      =>  $subnav->title,
                    "url"        =>  $subnav->url,
                    "src"        =>  $images[0],
                    "class"      =>  "prod_cat-image-{$subnav->ID} nb-wc-product-feature",
                    "subChild"   =>  $subChild   
                );
                
                $childrenList .= "<li class='js-subnav-icon nb-category-subnav {$id} ". ($isActive ? 'active' : '') . "' 
                                        data-container='product_catkey_{$subnav->object_id}'>";
                $childrenList .= "<a href='{$subnav->url}' class='nb-icon {$classes}' style='{$style}'>{$subnav->title}</a>";
                $childrenList .= "</li>";
                



                //one time activation
                if($isActive) $isActive = false;
            }
        }

        $childrenOutput .= "{$childrenList}</ul><!-- end of list -->";
        $childrenOutput .= "</div><!-- end of submenu -->";
        
        $childrenOutput .= "<div class='col-8 p-0 m-0'>";
        $childrenOutput .= "<div class='nb-dropdown-container'>";
        
        $childrenOutput .=  static::createImageList($imageArgs);
        
        $childrenOutput .= "</div>";
        $childrenOutput .= "</div>";
        $childrenOutput .= "</div><!-- container -->";
        $childrenOutput .= "</div><!-- wrapper -->";

        return $childrenOutput;

    }

    public static function getSubChildren($item) {

    }

    public static function createImageList($imageArgs) {

        $html = "";
        $active = true;
        
        foreach($imageArgs as $key => $arg) {
            $html .= "<nav id='product_catkey_{$key}' class='nb-wc-menu-product category-{$key} ". ($active ? 'active' : '') ."'>"; 
            $html .= "<!-- row --><div class='row m-0' style='height:100%'>";
            $html .= "<div class='col-md-12 subnav-top-product-list' style='background:rgba(255,255,255,0.7);height:100%'><ul>";
            
            foreach($arg['subChild'] as $subChild) {
                $html .= "<li><a href='{$subChild['url']}'>{$subChild['title']}</a></li>";
            }
            
            //$html .= sprintf("<li><a href='%s'>%s</a></li>",$arg['url'],__('See more...'));
            $html .= "</ul></div>";
            $html .= "</div><!-- end row-->";
            $html .= "<img src='{$arg['src']}' alt='{$arg['title']}' title='{$arg['title']}' class='product-cat-thumbnail' />";
            $html .= "</nav>";

            if($active) $active = false;

        }
        
	    return $html;
    }
}