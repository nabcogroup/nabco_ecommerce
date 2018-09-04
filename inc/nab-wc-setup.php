<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package nabcofurn_us
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function nabco_furnitures_woocommerce_setup() {
	
	add_theme_support( 'woocommerce' );
	
	add_theme_support( 'wc-product-gallery-zoom' );
	
	add_theme_support( 'wc-product-gallery-lightbox' );
	
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'nabco_furnitures_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function nabco_furnitures_woocommerce_scripts() {
	
	wp_enqueue_style( 'nabco-furnitures-woocommerce-style', get_template_directory_uri() . '/dist/css/woocommerce.css' );
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'nabco-furnitures-woocommerce-style', $inline_font );
}

add_action( 'wp_enqueue_scripts', 'nabco_furnitures_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'nabco_furnitures_woocommerce_header_cart' ) ) {
			nabco_furnitures_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'nabco_furnitures_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function nabco_furnitures_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		nabco_furnitures_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}





add_filter( 'woocommerce_add_to_cart_fragments', 'nabco_furnitures_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'nabco_furnitures_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function nabco_furnitures_woocommerce_cart_link() {
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
}


if(!function_exists('nabco_furnitures_search_form')) {
	
	function nabco_furnitures_search_form() {

?>
		<div class="mr-3">
			<a href="#"><i class="fa fa-search"></i></a>	
		</div>
<?php
	}
}



if ( ! function_exists( 'nabco_furnitures_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function nabco_furnitures_woocommerce_header_cart() {
		
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<div class="mr-3">
			<ul id="site-header-cart" class="site-header-cart">
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php nabco_furnitures_woocommerce_cart_link(); ?>
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
}

add_action('nabco_furnitures_header_display_fragment','nabco_furnitures_woocommerce_header_cart',10);


function nabco_furnitures_woocommerce_customer_account() {
	
	if(!is_user_logged_in()) {
		$description = __('Sign-in');
	}
	else {
		$current_user = wp_get_current_user();

		$description = $current_user->user_login;
	}

	echo '<div>' . sprintf('<a href="%s" class="user-content"><i class="fa fa-user"></i> <small>%s</small></a>',get_permalink(get_option('woocommerce_myaccount_page_id')),$description) . '</div>' ;

}

add_action('nabco_furnitures_header_display_fragment','nabco_furnitures_woocommerce_customer_account',20);



//quantity
function nabco_furnitures_qty_input() {

?>
	<script>
		jQuery(document).ready(function($) {
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

add_action('wp_footer','nabco_furnitures_qty_input');


function nabco_furnitures_wc_dashboard_button() {
	if(!is_page('my-account')) {
		return false;
	}
 ?>

<script>
	jQuery(document).ready(function($) {
		$(".nb-wc-mob-nav-button").on("click",function() {
			if(!$(".woocommerce-MyAccount-navigation").hasClass('mobile-button-active')) {
				$(".woocommerce-MyAccount-navigation").addClass('mobile-button-active');
			}
			else {
				$(".woocommerce-MyAccount-navigation").removeClass('mobile-button-active');
			}
		});
	})
</script>

<?php
}

add_action('wp_footer','nabco_furnitures_wc_dashboard_button');