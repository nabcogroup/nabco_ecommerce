<?php




class Nb_WoocommerceProductLoop {


    public function __construct() {
        
        $actions = array(

            /*********************************************************
            * Location: template/archive-product.php
            ********************************************/
            // add_action('woocommerce_before_shop_loop',[$this,'order_wrapper_opening'],5);
            // add_action('woocommerce_before_shop_loop',[$this,'order_wrapper_closing'],35);
            'woocommerce_before_shop_loop' => array(
                    array('action' => 'order_wrapper_opening','pos' => 5),
                    array('action' => 'order_wrapper_closing','pos' => 35),
            ),


            //archive-product.php
            //add_action('woocommerce_archive_description', [$this,'product_category_navigation'], 20);
            'woocommerce_archive_description' => array(
                array('action' => 'product_category_navigation','pos' => 20),
            ),

            
            //content-product.php
            // add_action('woocommerce_before_shop_loop_item',[$this,'product_content_wrapper_opening']);
            'woocommerce_before_shop_loop_item' => array(
                array('action' => 'product_content_wrapper_opening','pos' => 5),
            ),

            
            //remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart'); //remove add to cart since it is not included in the theme requirements
            // add_action('woocommerce_after_shop_loop_item',[$this,'product_content_wrapper_closing']);
            //content-product.php
            'woocommerce_after_shop_loop_item' => array(
                array('action' => 'product_content_wrapper_closing','pos' => 10),
                array('action' => 'woocommerce_template_loop_add_to_cart','pos' => 10, 'func' => 'remove'),
            ),

            //remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',10); //make a wrapper on the image by reposition
            // add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',20);  //place in new location
            // add_action('woocommerce_before_shop_loop_item_title',array($this,'thumbnail_wrapper_opening'),15);
            // add_action('woocommerce_before_shop_loop_item_title',array($this,'thumbnail_wrapper_closing'),25);
            //content-product.php
            'woocommerce_before_shop_loop_item_title' => array(
                array('action' => 'woocommerce_template_loop_product_thumbnail','pos' => 10, 'func' => 'remove'),
                array('action' => 'thumbnail_wrapper_opening','pos' => 15),
                array('action' => 'woocommerce_template_loop_product_thumbnail','pos' => 20, 'func' => 'wc'),
                array('action' => 'thumbnail_wrapper_closing','pos' => 25),
            ),

            // remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            // add_action('woocommerce_after_shop_loop_item_title', array($this,'wc_loop_price'), 10);
            //content-product.php
            'woocommerce_after_shop_loop_item_title' => array(
                array('action' => 'woocommerce_template_loop_price','pos' => 10, 'func' => 'remove'),
                array('action' => 'wc_loop_price','pos' => 10),
            ),
        );


        foreach ($actions as $tag => $actions) {
            foreach($actions as $value) {
                $pos = isset($value['pos']) ? $value['pos'] : 10;
                if(isset($value['func']) && $value['func'] == 'remove') {
                    remove_action($tag, $value['action'],$pos);
                }
                else if(isset($value['func']) && $value['func'] == 'wc') {
                    add_action($tag, $value['action'],$pos);
                }
                else {
                    add_action($tag, array($this,$value['action']),$pos);
                }
            }
        }

        //archive-product.php
        add_filter('woocommerce_catalog_orderby',[$this,'orderby_catalog'],10); //filter orderby
        
        //content-product.php
        add_filter('woocommerce_sale_flash',[$this,'woocommerce_sale_flash_wrapper']); //filter sale flash
        
        //*************** 
        //nabcosetting plugins location do not remove**********************
        add_filter('nb_wc_thumb_sale_price',array($this,'wc_loop_price'),10);
        add_filter('nb_wc_sale_flash', array($this,'wc_thumbnail_sale_flash'),10,2 );
        //***************************************** */


        //add_filter('woocommerce_get_price_html',array($this,'wc_get_price_html',10,2));
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item_title
     * - add wrapper in thumbnail to match theme bootstrap
    */
    public function thumbnail_wrapper_opening() {
        echo "<!-- opening wrapper--><div class='card-image-wrapper'>";
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item_title
     * - closing of wrapper
    */
    public function thumbnail_wrapper_closing() {
        echo "</div>";
    }

    /**
     * hooked: woocommerce_before_shop_loop
     * - add wrapper in ordering and result count
     ********************************/
    public function order_wrapper_opening() {
        echo '<!-- opening wrapper --><div class="wc-order-wrapper">';
    }

    /**
     * hooked: woocommerce_before_shop_loop
     *  - closing of wrapper
     ********************************/
    public function order_wrapper_closing() {
        echo '</div><!-- wrapper end -->';
    }

    /** 
     * hooked: woocommerce_sale_flash
     *  - add wrapper in sale flash to achieve theme style
    */
    public function woocommerce_sale_flash_wrapper($content) {

        $output = '<div class="sale-wrapper">';
        $output .= $content;
        $output .= '</div>';

        return $output;
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item
     *  - add wrapper to the content of the product to match bootstrap theme
    */
    public function product_content_wrapper_opening() {
        echo '<!-- product content wrapper --><div class="wc-card-product-content">';
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item
     *  - closing of wrapper
    */
    public function product_content_wrapper_closing() {
        echo '</div><!-- product content wrapper -->';
    }
   
   
    /**
     * hooked: woocommerce_catalog_orderby
     * - change the selection of catalog order by
     */
    public function orderby_catalog() {
        return array(
            ''              =>  __('--Select Sort--'),
            'price'         =>  __('Sort by price: low to high','woocommerce'),
            'price-desc'    =>  __('Sort by price: high to low','woocommerce'),
            'date'          =>  __('Sort by new arrival','woocommerce'),
        );
    }

    /**
     * hooked: woocommerce_archive_description
     * - create submenu on the the top of title
     */
    public function product_category_navigation() {
        
        $navigation_html = "";

        if(is_tax('product_cat')) {
            $cat = get_queried_object();
            $children = get_terms( $cat->taxonomy, array('parent'    => $cat->term_id));
            if($children && count($children) > 0) {
                $navigation_html = "<ul class='nb-shop-navigation wc-shop-category-subnav'>";
                foreach ($children as $key => $child) {
                    $navigation_html .= sprintf("<li><a href='%s'>%s</a></li>", $child->slug,$child->name);
                }
                $navigation_html .= "</ul>";
            }
        }
        
        echo $navigation_html;

    }

    public function wc_loop_price() {
        $html = "";
        if(get_theme_mod('nabco_ecommerce_price_control') == 'show') {
            global $product;

            if($product->is_on_sale()) {
                $html .= "<strong class='price'><small>WAS</small> <strike>" . wc_price($product->get_regular_price()) . "</strike> <small>NOW</small> " .wc_price($product->get_sale_price())."</strong>"; 
            }
            else {
                $html .= sprintf('<span class="price">%s</span>' ,$product->get_price_html());
            }
        }
        else {
            $html = "";
        }
        echo $html;
    }

    public function wc_thumbnail_sale_flash($content,$product) {


        $showPercentage = get_theme_mod('show_percentage',true);
        $html = "";
        if($showPercentage) {
            $regularPrice = ($product->get_regular_price() == "") ? 0 : $product->get_regular_price();
            $salePrice = $product->get_sale_price(); 
            $percentage = (floatval($regularPrice) - floatval($salePrice)) / floatval($regularPrice) * 100; 
            $html = round($percentage) . '% Off Sale';
        }

        return '<div class="sale-wrapper"><span class="onsale">' . esc_html__($html) . '</span></div>';
        
        
    }

    public function wc_get_price_html($price,$object) {

    }


   
}

return new Nb_WoocommerceProductLoop();