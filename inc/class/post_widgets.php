 <?php

/***********************************************
Register custom widget
*/


function td_load_widget() {
    register_widget( 'Nab_SpecificPost_Widget' );
}


// Creating the widget 
class Nab_SpecificPost_Widget extends WP_Widget {
 
    function __construct() {
        
        parent::__construct(
            // Base ID of your widget
            'specificpost_widget', 
            
            // Widget name will appear in UI
            __('Post Widget', 'post_widget_domain'), 
            
            // Widget description
            array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'post_widget_domain' ), ) 
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        
        $title = apply_filters( 'widget_title', $instance['title'] );

        $branch_1 = isset($instance['branch_1']) ? $instance['branch_1'] : '';
        $branch_2 = isset($instance['branch_2']) ? $instance['branch_2'] : '';
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        


        //get post query here
        $margs = [
            'post_name__in' => [$branch_1,$branch_2],
            'orderby'   =>  'name',
            'order'     =>  'ASC'
        ];
        
        $the_query = new WP_Query($margs);
        if($the_query->have_posts())  :
            while($the_query->have_posts()) : $the_query->the_post();
                the_content();
            endwhile;
        endif;
        
        wp_reset_postdata();
        //end here


        echo $args['after_widget'];

    }
         
    // Widget Backend 
    public function form( $instance ) {
        
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
            $branch_1 = $instance['branch_1'];
            $branch_2 = $instance['branch_2'];
        }
        else {
            $title = __( 'New title', 'post_widget_domain' );
            $branch_1 = '';            
            $branch_2 = '';
        }



        //Branch 1
        $input_branch1 = $input_branch1 .  '<p>';
        $input_branch1 =  $input_branch1 . '<label>Branch 1:</label>';
        $input_branch1 =  $input_branch1 . '<input class="widefat" 
                                                id="'. $this->get_field_id( 'branch_1' ) .'" 
                                                name="'. $this->get_field_name( 'branch_1' ) .'"  
                                                value="' . esc_attr( $branch_1 ) . '"/></p>';

        //Branch 2
        $input_branch2 = '<p>';
        $input_branch2 =  $input_branch2 . '<label for="'. $this->get_field_id( 'branch_2' ) . '">' . _e( 'Branch 2:' ) . '</label>';
        $input_branch2 =  $input_branch2 . '<input class="widefat" 
                                                id="' . $this->get_field_id( 'branch_2' ) . '" 
                                                name="' . $this->get_field_name( 'branch_2' ) . '" type="text" 
                                                value="'. esc_attr( $branch_2 ) . '" />';
        $input_branch2 = $input_branch2 . '</p>';

        // Widget admin form
        $form_outuput =  '<p>';
        $form_outuput =  $form_outuput . '<label for="'. $this->get_field_id( 'title' ) . '">' . _e( 'Title:' ) . '</label>';
        $form_outuput =  $form_outuput . '<input class="widefat" 
                                                id="' . $this->get_field_id( 'title' ) . '" 
                                                name="' . $this->get_field_name( 'title' ) . '" type="text" 
                                                value="'. esc_attr( $title ) . '" /></p>';
        
        $form_outuput = $form_outuput . $input_branch1 . $input_branch2;
        

        echo $form_outuput;
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['branch_1'] = ( ! empty( $new_instance['branch_1'] ) ) ? strip_tags( $new_instance['branch_1'] ) : '';
        $instance['branch_2'] = ( ! empty( $new_instance['branch_1'] ) ) ? strip_tags( $new_instance['branch_2'] ) : '';
        return $instance;
    }
} // Class  ends here