<?php


/***********************************************
Register custom widget
*/


class WC_ProductRating_Cust extends WC_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_rating_filter';
        $this->widget_description = __( 'Display a list of star ratings to filter products in your store. (Custom Version)', 'woocommerce' );
        $this->widget_id          = 'wc_custom_rating_filter';
        $this->widget_name        = __( 'Custom Filter Products by Rating', 'woocommerce' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Average rating', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' ),
            ),
            'product_count' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 5,
                'label' => __( 'Number of products to show', 'woocommerce' ),
            )
        );
        
        parent::__construct();
           
    }

    public function widget($args,$instance) {
        
        if ( $this->get_cached_widget( $args ) ) {
            return;
        }

        ob_start();

        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'meta_key'       => '_wc_average_rating',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
            'meta_query'     => WC()->query->get_meta_query(),
            'tax_query'      => WC()->query->get_tax_query(),
        );

        $wpq = new WP_Query( $query_args );

        if ( $wpq->have_posts() ) {

            $this->widget_start( $args, $instance );

            echo wp_kses_post( apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget">' ) );

            $template_args = array(
                'widget_id'   => $args['widget_id'],
                'show_rating' => true,
            );

            while ( $wpq->have_posts() ) {
                $wpq->the_post();
                wc_get_template( 'content-widget-product.php', $template_args );
            }

            echo wp_kses_post( apply_filters( 'woocommerce_after_widget_product_list', '</ul>' ) );

            $this->widget_end( $args );
        }
        
    }

    

   


}