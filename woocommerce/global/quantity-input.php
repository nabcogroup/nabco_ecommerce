<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'woocommerce' ), strip_tags( $args['product_name'] ) ) : '';
	?>
	<div class="quantity col-md-3 col-sm-12 py-1">
		<div class="p-0">
			<div id="qtyInput" class="nb-input-group-wrapper">
				<button id="qtyDec" class="nb-wc-input-qty__modifier nb-wc-input-qty__modifier--left" type="button" data-type="dec">-</button>
				<input
					type="text"
					id="<?php echo esc_attr( $input_id ); ?>"
					maxlength="3"
					class="nb-wc-input-qty input-text qty text"
					step="<?php echo esc_attr( $step ); ?>"
					min="<?php echo esc_attr( $min_value ); ?>"
					max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
					name="<?php echo esc_attr( $input_name ); ?>"
					value="<?php echo esc_attr( $input_value ); ?>"
					title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
					pattern="<?php echo esc_attr( $pattern ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>"
					aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
					<button id="qtyInc" class="nb-wc-input-qty__modifier nb-wc-input-qty__modifier--right" type="button" data-type="inc">+</button>
			</div>
		</div>
	</div>
	<?php
}
