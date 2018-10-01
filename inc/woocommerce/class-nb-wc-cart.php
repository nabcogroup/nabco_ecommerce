<?php


class Nb_WooCommerceMiniCart {

}

class Nb_WoocommerceCart {
    
    public static $instance;

    public function createInstance() {
        if(is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct() {

        
        add_filter( 'wc_add_to_cart_message_html',[$this,'cart_message_html'], 10);
        add_filter('woocommerce_widget_cart_item_quantity',[$this,'mini_cart_item_qty'],10,3);

       
        /** 
         * Minicart
         *  nabco_furnitures_display_fragment - added to display in theme header
        *************************************/
        add_filter( 'woocommerce_add_to_cart_fragments', array($this,'cart_link_fragment') );
        
        add_action('nabco_furnitures_header_display_fragment',array($this,'header_cart'), 10 );
        
        /*****************************
         * Qty Input script
        *****************************/
        add_action('wp_footer', array($this,'nabco_furnitures_qty_input_script' ) );

    }

   
    
    /**
     * hooked: wc_add_to_cart_message_html
     * used: add_filter
     * - change cart message button html to match theme
     */
    public function cart_message_html() {
    
        global $woocommerce;
        
        // Output success messages
        if (get_option('woocommerce_cart_redirect_after_add')=='yes') :
            $return_to  = get_permalink(woocommerce_get_page_id('shop'));
            $message    = sprintf('%s <a href="%s" class="button btn btn-sm btn-success">%s</a> ',__('Product successfully added to your cart.', 'woocommerce'), $return_to, __('Continue Shopping &rarr;', 'woocommerce') );
        else :
            $message    = sprintf('%s <a href="%s" class="button btn btn-sm btn-success">%s</a> ',__('Product successfully added to your cart.', 'woocommerce') ,get_permalink(wc_get_page_id ('cart')), __('View Cart &rarr;', 'woocommerce'));
        endif;

        return $message;
    }

     /** 
     * hooked: woocommerce_widget_cart_item_quantity
     * - modify qty item in minicart to match in theme
    */
    public function mini_cart_item_qty($content,$item,$key) {
        
        $content = "<span class='quantity'><strong>Quantity:&nbsp;</strong>{$item['quantity']}</span>";
        
        return $content;
    }

    /**
	 * hooked: woocommerce_add_to_cart_fragments
	 * - Ensure cart contents update when products are added to the cart via AJAX.
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	public function cart_link_fragment( $fragments ) {
		ob_start();
        $this->cart_link();
        $fragments['a.cart-management'] = ob_get_clean();
        return $fragments;
    }

    /**
	 * Cart Link.
	 * - Displayed a link to the cart including the number of items present and the cart total.
     * - call in cart_link_fragment 
     * - call in header_cart 
	 * @return void
	 */
	public function cart_link() {
		?>
            <a id="cart_management" class="cart-collections cart-management" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'nabco-furnitures' ); ?>">
                <i class="fa  fa-shopping-bag "></i>
                <?php
                $item_count_text = sprintf(
                    /* translators: number of items in the mini cart. */
                    _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'nabco-furnitures' ),
                    WC()->cart->get_cart_contents_count()
                );
                
                ?>

                <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
            </a>
		<?php
    }
    
    /**
	 * hooked: nabco_furnitures_header_display_fragment
	 * - Display Header Cart.
	 * @return void
	 */
	public function header_cart() {
		
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
        
        ?>
        
        <div class="mr-3">
			<ul id="site-header-cart" class="site-header-cart">
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php $this->cart_link(); ?>
				</li>
            </ul>
            <div>
                <?php
					$instance = array('title' => '');
					the_widget( 'WC_Widget_Cart', $instance );
                ?>
            </div>
        </div>
        
		<?php
    }

    
    
        
    /** 
     * hooked: wp_footer
     * - Script for quantity input in products and cart 
     * - Trigger only when single product and cart render 
    **************************/
    public function nabco_furnitures_qty_input_script() {
        
        if(is_product() || is_page("cart")) {
            ?>
                <script>
                    jQuery(document).ready(function($) {
                        console.log("cart script activated");
                        
                        //control
                        $(document).on('click','#qtyInc',function(e) {
                            var input = $(this).prev('input.qty');
                            var inputValue = parseInt(input.val());
                            var step = input.attr('step');
                            step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
                            if(inputValue < 100) {
                                input.val( inputValue + step ).change();
                            }
                        })

                        $(document).on('click','#qtyDec',function(e) {
                            var input = $(this).next('input.qty');
                            var inputValue = parseInt(input.val());
                            var step = input.attr('step');
                            step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
                            if (inputValue > 1) {
                                input.val( inputValue - step ).change();
                            }
                        })
                    })
                </script>
            <?php 
        }
    }
}

return new Nb_WoocommerceCart();