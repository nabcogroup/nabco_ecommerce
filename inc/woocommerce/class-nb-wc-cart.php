<?php

class Nb_WoocommerceCart {
    
    public static $instance;

    public function createInstance() {
        if(is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct() {
        
        add_action('woocommerce_before_cart',[$this,'addCartBootstrapWrapper'],10);
        add_action('woocommerce_after_cart',[$this,'addCartBootstrapClosing'],10);
        
        //remove default empty cart display and replace with bootstrap style
        remove_action('woocommerce_cart_is_empty','wc_empty_cart_message',10);
        add_action('woocommerce_cart_is_empty',[$this,'empty_cart_message'],10);

        //woocommerce cart message
        add_filter( 'wc_add_to_cart_message_html',[$this,'cart_message_html'], 10);


        //mini cart header
        add_filter('woocommerce_widget_cart_item_quantity',[$this,'modWidgetCartItemQuantity'],10,3);

        //remove action and replace 
        remove_action('woocommerce_widget_shopping_cart_buttons','woocommerce_widget_shopping_cart_button_view_cart',10);
        remove_action('woocommerce_widget_shopping_cart_buttons','woocommerce_widget_shopping_cart_proceed_to_checkout',20);

        add_action('woocommerce_widget_shopping_cart_buttons',[$this,'modWidgetShoppingCartProceedToCheckout'],10);
        
        //minicart 
        add_filter( 'woocommerce_add_to_cart_fragments', array($this,'cart_link_fragment') );
        add_action('nabco_furnitures_header_display_fragment',array($this,'header_cart'),10);
        //qty input script
        add_action('wp_footer',array($this,'nabco_furnitures_qty_input'));

    }

    public function modWidgetShoppingCartButtonViewCart() {
        echo '<div class="col-md-6">';
        echo '<!-- open col --><a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward btn btn-block btn-secondary">' . esc_html__( 'View Cart', 'woocommerce' ) . '</a><!-- end-->';
        echo '</div>';
    }

    public function modWidgetShoppingCartProceedToCheckout() {
        echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward btn btn-block  btn-secondary">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
    }



    public function modWidgetCartItemQuantity($content,$item,$key) {
        
        $content = "<span class='quantity'><strong>Quantity:&nbsp;</strong>{$item['quantity']}</span>";
        
        return $content;
    }

    public function empty_cart_message() {
        echo '<div class="col-md-12 text-center">';
        echo '<h1 class="cart-empty">' . wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ) . '</h1>';
        echo '</div>';
    }

    public function addCartBootstrapWrapper() {
        
        echo  "<!-- cart wrapper --><div class='row'>";
    }

    public function addCartBootstrapClosing() {
        echo "</div>";
    }

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
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	public function cart_link_fragment( $fragments ) {
		ob_start();
        
        $this->cart_link();
        
        $fragments['a.cart-contents'] = ob_get_clean();
        
        return $fragments;
    }

    /**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	public function cart_link() {
		?>
            <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'nabco-furnitures' ); ?>">
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
	 * Display Header Cart.
	 *
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
				<li class="d-none d-sm-block">
					<?php
					$instance = array('title' => '');
					the_widget( 'WC_Widget_Cart', $instance );
					?>
				</li>
			</ul>
		</div>
		<?php
    }
    
        
    /*
        Script for quantity input in products and cart
        Trigger only when single product and cart render
    */
    public function nabco_furnitures_qty_input() {
        
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