<?php


add_action('widgets_init','nabco_furnitures_load_widget');

function nabco_furnitures_load_widget() {
    register_widget( 'Nab_SearchProductWidget' );
}

class Nab_SearchProductWidget extends WP_Widget {

    function __construct() {
        
        parent::__construct(
            // Base ID of your widget
            'nab_product_search_widget', 
            
            // Widget name will appear in UI
            __('Nabco Product Search Widget'), 
            
            // Widget description
            array( 'description' => __( 'Product Search Form Nabco Theme'), ) 
        );
    }

    public function widget($args,$instance) {


        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        echo nabco_furnitures_product_form_search();
        echo $args['after_widget'];
    }

}