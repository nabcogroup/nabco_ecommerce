<?php

class Nb_WoocommerceSingleProduct {


    public function __construct() {
        
      
        /******************************************
        * add wrapper to wc print notice
        * Hook: woocommerce_before_single_product.
        * @hooked wc_print_notices - 10 
        ******************************************/
        // add_action('woocommerce_before_single_product',[$this,'beforeSingleProduct'],5);
        // add_action( 'woocommerce_after_single_product',[$this,'afterSingleProduct'],15);
        // add_action('woocommerce_before_add_to_cart_form',[$this,'beforeCartForm'],10);
        // add_action( 'woocommerce_after_add_to_cart_form', [$this,'afterCartForm'],10 );

        //change meta position
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);
        

        remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);

        add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',10);
        add_action('woocommerce_single_product_summary','woocommerce_template_single_price',20);

        //
        //insert dynamic price display
        add_action('woocommerce_single_product_summary',[$this,'productVariationPrice'],1);

        /**************************************************
		* Hook: woocommerce_before_single_product_summary.
		*
		* @hooked woocommerce_show_product_sale_flash - 10
		**************************************************/
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',10);

        add_action('nb_woocommerce_after_sales_price','woocommerce_show_product_sale_flash',10);
        

         /****************** 
          * Hook: woocommerce_before_add_to_cart_quantity & woocommerce_after_add_to_cart_quantity
         */
         //add_action( 'woocommerce_before_add_to_cart_quantity', array($this,'beforeAddToCartQuantityWrapper'),10 );
         //add_action( 'woocommerce_after_add_to_cart_quantity', array($this,'afterAddToCartQuantityWrapper'), 10 );

        
        //insert class in product variation selection
        add_filter('woocommerce_dropdown_variation_attribute_options_args',[$this,'dropdownVariationOptionsAddBootstrapForm']);
        add_filter('woocommerce_product_review_comment_form_args',[$this,'changeCommentAuthorField'],10);
        add_filter('woocommerce_product_review_comment_form_args',array($this,'changeCommentSubmitButton'),20);
    }

   
    public function changeCommentSubmitButton($comment_form) {

        $comment_form['submit_button'] = '<div class="form-group text-right"><input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-secondary" value="%4$s" /></div>';

        return $comment_form;
    }

    public function changeCommentAuthorField($comment_form) {
        
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

    public function addVariationBootstrapWrapper() {
        echo "<div class='row'>";
    }

    public function addVariationBootstrapClosing() {
        echo "</div>";
    }
  
    public function dropdownVariationOptionsAddBootstrapForm($args) {
        
        $args['class'] = 'form-control';
        
        return $args;
    }

    /*
    *   Remove the Price range
    */
    public function productVariationPrice() {
        
        if(is_product()) {

            global $product;

            if($product->is_type('variable')) {

               remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

            }
            
        }

        
    }

    public function beforeAddToCartQuantityWrapper() {
        echo '<!-- wrapper quantity --><div class="col-md-6">';
    }

    public function afterAddToCartQuantityWrapper() {
        echo '</div><!-- end wrapper -->';
    }

    public function beforeCartForm() {
        echo "<div class='my-3 cart-form-wrapper'>";
    }

    public function afterCartForm() {
        echo "</div>";
    }


    public function beforeSingleProduct() {

        echo "<!-- product wrapper --><div class='woocommerce-content-single-product-wrapper'>";

    }

    public function afterSingleProduct() {

        echo "</div><!-- end product wrapper -->";

    }
}

$singleProduct = new Nb_WoocommerceSingleProduct();