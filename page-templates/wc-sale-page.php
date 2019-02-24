<?php 

    
/**
 * Template Name: Woocommerce Sale Page
 *
 * Template for displaying a woocommerce sale page.
 *
 * @package understrap
 */
get_header();
?>

<article class="page-wrapper">
    <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <header class="woocommerce-products-header">
                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <h1 class="woocommerce-products-header__title page-title"><?php the_title(); ?></h1>
                <?php endif; ?>
            </header>
            <div class="body-content">
                <div class="row">
                    <div class="col-md-9 woocommerce-shop-page">
                    
                        <?php
                            /**
                             * Hook: woocommerce_before_shop_loop.
                             *
                             * @hooked wc_print_notices - 10
                             * @hooked woocommerce_result_count - 20
                             * @hooked woocommerce_catalog_ordering - 30
                             */
                            do_action( 'woocommerce_before_shop_loop' );
                        ?> 

                        <?php the_content(); ?>
                    </div>
                    <div class="col-md-3">
                        <?php do_action( 'woocommerce_sidebar' ); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</article>

<?php get_footer(); ?>