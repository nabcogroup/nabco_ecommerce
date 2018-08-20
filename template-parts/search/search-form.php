
<?php 


?>
<form class="form-horizontal nb-form" style="display:block;" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="col-md-12">
        <div class="input-group">
            <input type="text" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="form-control" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); ?>" aria-label="Username" aria-describedby="basic-addon1" name="s">
            <input type="hidden"   name="post_type" value="product" />
            <div class="input-group-append">
                <button class="input-group-text btn btn-primary" id="basic-addon1"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </div>
</form>


