<?php




class Nb_WoocommerceProductLoop extends Theme_Hook {

    public function __construct() {
        
        $this->actions = array(

            /*********************************************************
            * Location: template/archive-product.php
            ********************************************/
            'woocommerce_before_shop_loop' => array(
                array('fn' => array($this,'order_wrapper_opening'),'pos' => 5),
                array('fn' => array($this,'order_wrapper_closing'),'pos' => 35),
            ),

            //archive-product.php
            'woocommerce_archive_description' => array('fn' => array($this,'product_category_navigation'),'pos' => 20),
            
            //content-product.php
            'woocommerce_before_shop_loop_item' => array('fn' => array($this,'product_content_wrapper_opening'),'pos' => 5),
            
            //content-product.php
            'woocommerce_after_shop_loop_item' => array(
                array('fn' => array($this,'product_content_wrapper_closing'),'pos' => 10),
                array('fn' => 'woocommerce_template_loop_add_to_cart','pos' => 10, 'event' => 'remove'),
            ),
            
            //content-product.php
            'woocommerce_before_shop_loop_item_title' => array(
                array('fn' => array($this,'wc_sale_flash_setup'), 'pos' => 5),
                array('fn' => 'woocommerce_template_loop_product_thumbnail','pos' => 10, 'event' => 'remove'),
                array('fn' => array($this,'thumbnail_wrapper_opening'),'pos' => 15),
                array('fn' => 'woocommerce_template_loop_product_thumbnail','pos' => 20,),
                array('fn' => array($this,'thumbnail_wrapper_closing'),'pos' => 25),
            ),
            
            'woocommerce_no_products_found' => array(
                array('fn' => 'wc_no_products_found','pos' => 10, 'event' => 'remove'),
                array('fn' => array($this,'wc_no_products_found'), 'pos' => 10),
            ),
            
            'woocommerce_after_shop_loop_item_title' => array(
                array('fn' => array($this,'wc_remove_price'), 'pos' => 5),
            )
        );


        $this->filters = array(
            
            'woocommerce_catalog_orderby' => 'orderby_catalog',
            
            'woocommerce_sale_flash'    =>  'woocommerce_sale_flash_wrapper',

            //nabcosetting plugins location do not remove**********************
            'nb_wc_sale_flash' => array('fn' => array($this,'wc_thumbnail_sale_flash'), 'pos' => 10, 'param' => 2)
            
        );

        parent::__construct();

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
   

    public function wc_thumbnail_sale_flash($content,$product) {
        
        $html = "<strong class='col-md-6' style='font-size:12px;padding-top:2px'><small>WAS</small> <strike>" . 
                wc_price($product->get_regular_price()) . "</strike></strong> <strong class='col-md-6'><small>NOW</small> " . 
                wc_price($product->get_sale_price())."</strong>";
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

    /**
     * Display No product found
     */
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

    /** 
     * Remove Price
    *********************************/
    public function wc_remove_price() {
        if(get_option('wc_hide_price','yes') == 'yes' && !current_user_can('manage_options') ) {
            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
        }
    }
   
}

return new Nb_WoocommerceProductLoop();