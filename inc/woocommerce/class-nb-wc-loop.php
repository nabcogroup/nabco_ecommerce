<?php




class Nb_WoocommerceProductLoop {


    public function __construct() {
        
        $actions = array(

            /*********************************************************
            * Location: template/archive-product.php
            ********************************************/
            'woocommerce_before_shop_loop' => array(
                array('action' => 'order_wrapper_opening','pos' => 5),
                array('action' => 'order_wrapper_closing','pos' => 35),
            ),

            //archive-product.php
            'woocommerce_archive_description' => array(
                array('action' => 'product_category_navigation','pos' => 20),
            ),

            
            //content-product.php
            'woocommerce_before_shop_loop_item' => array(
                array('action' => 'product_content_wrapper_opening','pos' => 5),
            ),

            
            
            //content-product.php
            'woocommerce_after_shop_loop_item' => array(
                array('action' => 'product_content_wrapper_closing','pos' => 10),
                array('action' => 'woocommerce_template_loop_add_to_cart','pos' => 10, 'func' => 'remove'),
            ),
            //content-product.php
            'woocommerce_before_shop_loop_item_title' => array(
                array('action' => 'wc_sale_flash_setup', 'pos' => 5),
                array('action' => 'woocommerce_template_loop_product_thumbnail','pos' => 10, 'func' => 'remove'),
                array('action' => 'thumbnail_wrapper_opening','pos' => 15),
                array('action' => 'woocommerce_template_loop_product_thumbnail','pos' => 20, 'func' => 'wc'),
                array('action' => 'thumbnail_wrapper_closing','pos' => 25),
            ),
            'woocommerce_no_products_found' => array(
                array('action' => 'wc_no_products_found','pos' => 10, 'func' => 'remove'),
                array('action' => 'wc_no_products_found', 'pos' => 10),
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
        add_filter('woocommerce_sale_flash',array($this,'woocommerce_sale_flash_wrapper')); //filter sale flash
        
        //*************** 
        //nabcosetting plugins location do not remove**********************
        add_filter('nb_wc_sale_flash', array($this,'wc_thumbnail_sale_flash'),10, 2 );
        //***************************************** */

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
            $html .= sprintf('<span class="price">%s</span>' ,$product->get_price_html());
        }
        else {
            $html = "";
        }
        echo $html;
    }

    public function wc_thumbnail_sale_flash($content,$product) {
        
        $html = "";
        
        // $regularPrice = ($product->get_regular_price() == "") ? 0 : $product->get_regular_price();
        // $salePrice = $product->get_sale_price(); 
        // $percentage = (floatval($regularPrice) - floatval($salePrice)) / floatval($regularPrice) * 100; 
        
        $html = "<strong class='col-md-6' style='font-size:12px;padding-top:2px'><small>WAS</small> <strike>" . wc_price($product->get_regular_price()) . "</strike></strong> <strong class='col-md-6'><small>NOW</small> " .wc_price($product->get_sale_price())."</strong>";
        
        // $html = round($percentage) . '% Off Sale';   
        return '<div class="sale-wrapper" style="background-color:#e50000;width:100%;padding:10px 0"><span class="onsale row">' . wp_kses_post($html) . '</span></div>';

    }

    /******************************************************
     * ver 1.2 
     * check the plugin setup if sale flash is hide then hide it 
    ********************************************************/
    public function wc_sale_flash_setup() {
        
        if(get_option('wc_hide_sale_flash','yes') == 'yes' ) {
            remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
        }
        
    }


    public function wc_no_products_found() {
        if(isset($_GET['s'])) {
            //search
            ?>
                <p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
            <?php
        }
        else {
            ?>
                <p class="woocommerce-info"><?php _e( 'Products are coming soon...', 'woocommerce' ); ?></p>
            <?php
        }
    }
   
}

return new Nb_WoocommerceProductLoop();