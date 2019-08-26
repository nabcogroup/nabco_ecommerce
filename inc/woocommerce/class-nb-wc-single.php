<?php

class Nb_WoocommerceSingleProduct {
   
    public function __construct() {
        
        
        /**************************************************
         * content-single-product.php
         * 
         * remove all default template location [meta,price,exerpt]
         * change the position to fit into theme
         * 
         * remove sale flash in before single product summary
         * insert sale flash after sale price
         **************************************************/
        $actions = array(
            'woocommerce_single_product_summary' => array(
                //remove everything and rearrange
                array('action' => 'woocommerce_template_single_meta','pos' => 40, 'func' => 'remove'),
                array('action' => 'woocommerce_template_single_price','pos' => 10, 'func' => 'remove'),
                array('action' => 'woocommerce_template_single_excerpt','pos' => 20, 'func' => 'remove'),
                array('action' => 'remove_sale_price_when_variation','pos' => 1),
                array('action' => 'woocommerce_template_single_meta','pos' => 7, 'func' => 'wc'),
                array('action' => 'woocommerce_template_single_excerpt','pos' => 10, 'func' => 'wc'),
            ),
        );

        remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
        
        add_action('woocommerce_single_product_summary',array($this,'remove_sale_price_when_variation'),1);
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);
        add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',10);
        //add_action('woocommerce_single_product_summary',array($this,'enable_jetpack_social_sharing'),60);
        
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',10);
        //add_action('nb_woocommerce_after_sales_price','woocommerce_show_product_sale_flash',10);

        //modify price display on variation
        add_filter('woocommerce_available_variation',array($this,'set_variation_price'),10,3);
        //add_filter('nabco_furniture_sale_percentage',array($this,'sale_percentage_by_discount'),10,1);
        
        /** 
         * source: class-wcml-attributes.php 
        */
        add_filter('woocommerce_dropdown_variation_attribute_options_args',array($this,'dropdown_variation_attribute_options_args'));

        add_filter('woocommerce_product_review_comment_form_args',[$this,'comment_author_field'],10);
        add_filter('woocommerce_product_review_comment_form_args',array($this,'comment_submit_button'),20);



        //check if ecommerce enabled
        if(get_option('wc_disabled_shop_cart','yes')  == 'yes') {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
    }

    /** 
     * hooked-filter: woocommerce_product_review_comment_form_args
     * change submit button into bootstrap theme format
    */
    public function comment_submit_button($comment_form) {
        $comment_form['submit_button'] = '<div class="form-group text-right"><input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-secondary" value="%4$s" /></div>';
        return $comment_form;
    }

    /**
     *  hooked: woocommerce_product_review_comment_form_args
     *  @used: apply_filter
     *  - change review field to bootstrap format
     ***********************/
    public function comment_author_field($comment_form) {
        
        $commenter = wp_get_current_commenter();

        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
            
            $comment_form['comment_field'] = '<div class="comment-form-rating row"><label for="rating" class="col-md-3  text-right">' . esc_html__( 'Your rating', 'woocommerce' ) . '</label><div class="col-md-9"><select name="rating" id="rating" aria-required="true" required>
                <option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
                <option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
                <option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
                <option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
                <option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
                <option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
            </select></div></div>';
        }

        $comment_form['comment_field'] .= '<div class="comment-form-comment form-group row"><label for="comment" class="col-md-3 text-right">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><div class="col-md-9"><textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true" required></textarea></div></div>';

        $comment_form['fields'] = array(
            'author' => '<div class="comment-form-author form-group row">' . '<label for="author" class="col-md-3  text-right">' . esc_html__( 'Name', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label> ' .
                        '<div class="col-md-9"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" class="form-control" required /></div></div>',
            'email'  => '<div class="comment-form-email form-group row"><label for="email" class="col-md-3  text-right">' . esc_html__( 'Email', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label> ' .
                        '<div class="col-md-9"><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" class="form-control" size="30" aria-required="true" required /></div></div>',
            );

        return $comment_form;

    }

    public function enable_jetpack_social_sharing() {
        if ( function_exists( 'sharing_display' ) ) {
            sharing_display( '', true );
        }
         
        if ( class_exists( 'Jetpack_Likes' ) ) {
            $custom_likes = new Jetpack_Likes;
            echo $custom_likes->post_likes( '' );
        }
    }
  
    /**
    *   hooked: woocommerce_dropdown_variation_attribute_options_args
    *   @used: apply_filter 
    *   - add form control to make bootstap form
    **************************************/
    public function dropdown_variation_attribute_options_args($args) {
        
        $args['class'] = 'form-control';
        
        return $args;
    }

    /**
    *   hooked: woocommerce_single_product_summary
    *   - add only if not variable product
    ***************************/
    public function remove_sale_price_when_variation() {
        if(is_product()) {
            global $product;
            if(false === $product->is_type('variable')) {
                //add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',20);
               add_action( 'woocommerce_single_product_summary', array($this,'wc_single_price'),20);
            }
            else {
               //do nothing 
            }
        }
    }

    

    /**
    * hooked: woocommerce_available_variation
    * - add discount price in sale price in variation
    * @param $args,$object,$variation
    * @return html with price and discount
    ************************/
    public function set_variation_price($args,$object,$variation) {
        
        $htmlSaleFlash = "";

        if(isset($args['price_html'])) {

            ob_start();
            

            if($variation->is_on_sale())  {

                $discountHtml = $this->sale_percentage_by_discount($variation);
                $htmlSaleFlash = sprintf("<span class='onsale ml-3'>%s %s</span>",$discountHtml,esc_html__( ' Sale! ', 'woocommerce' ));
            }
            $priceHtml = sprintf("<span>%s</span>",__('Price'));
            $args["price_html"] = "<p class='price'>{$priceHtml}: {$variation->get_price_html()} {$htmlSaleFlash}</p>";
        }

        return $args;
    }

    /**
     *  hooked: nabco_furniture_sale_percentage - added in single-product/sale-flash.php
     *  - added sale flash with discount only when in product single
     *  - added when variation price is enabled since we remove the main price range
     */
    public function sale_percentage_by_discount($product) {

        if(is_product()) {

            $showPercentage = get_theme_mod('show_percentage',true);
           
            $html = "";
            if($showPercentage) {
                $regularPrice = ($product->get_regular_price() == "") ? 0 : $product->get_regular_price();
                $salePrice = $product->get_sale_price(); 
                $percentage = (floatval($regularPrice) - floatval($salePrice)) / floatval($regularPrice) * 100; 
                $html = round($percentage) . '% off';
            }

            return $html;
        }
    }

    public function wc_single_price() {

        global $product;

        $price_html = $product->get_price_html();
        if($price_html) {
            $html = "<p class='price my-2' style='font-size:18px'>";
            if($product->is_on_sale()) {
                $html .= "<strong class='mr-2'>Price: </strong>";
                $html .= $price_html; 
            }
            else {
                $html .= sprintf('<strong class="mr-2">Price:</strong> %s' ,$price_html);
            }
            $html .= "</p>";
        }
        else {
            $html = $this->wc_show_no_price_detail();
        }


        echo $html;
    }
    
    public function wc_show_no_price_detail() {
        $html = "";
        if(get_option('wc_hide_price','yes') == 'yes') {
            $text =  get_option('wc_text_replacement_inquiry', '*Price not displayed');
            ob_start();
            ?>
            <p class='nb_wc_price_wrapper price my-2' style='text-transform:none'>
                <?php echo wp_kses_post($text); ?>
            </p>
            <?php
            $html = ob_get_clean();
        }
        
        return $html;
        
    }

    public function wc_single_selected_price() {
        
        global $product;
        
        $html = "<p class='price my-2' style='font-size:18px'>";
        
        if($product->is_on_sale()) {
            $html .= "<strong class='mr-2'>Price: </strong>";
            $html .= $product->get_price_html();
            $html .= "&nbsp;&nbsp;";     
            //$html .=  "<span class='onsale'>".$this->sale_percentage_by_discount($product)."</span>";
        }
        else {
            $html .= "";
            $html .= sprintf('<strong class="mr-2">Price:</strong> %s' ,$product->get_price_html());
        }
        $html .= "</p>";
        
        echo $html;
    }
  
}



return new Nb_WoocommerceSingleProduct();