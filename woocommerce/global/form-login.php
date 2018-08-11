<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<div class="row">
	<div class="col-md-12">
		<form class="woocommerce-form woocommerce-form-login login form-horizontal" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>
		
			<?php do_action( 'woocommerce_login_form_start' ); ?>
		
			<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>
			
			<div class="col-md-4">
				
				<div class="form-row-first form-group row">
					<div class="col-md-12">
						<input type="text" class="input-text form-control" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" name="username" id="username" autocomplete="username" />
					</div>
				</div>
	
				<div class="form-group row form-row-last form-group">
					<div class="col-md-12">
						<input class="input-text form-control" type="password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" name="password" id="password" autocomplete="current-password" />
					</div>
				</div>

				<?php do_action( 'woocommerce_login_form' ); ?>
				
				<div class="form-group row">
						
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<div class="col-md-12">
						<button type="submit" class="button btn btn-primary btn-block" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
					</div>
					
					<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
					
					<div class="col-md-6">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <small><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></small>
						</label>
					</div>
					<div class="col-md-6">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
					</div>
					
				</div>
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>
		
		</form>
	</div>
</div>
