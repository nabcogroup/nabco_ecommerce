<?php

class Nab_Customizer {


    public function __construct() {

        //add_action( 'customize_preview_init', array($this,'customizePreviewJs'));
        add_action('customize_register', array($this,'addPostMessageSupport'));
        add_action('customize_register', array($this,'themeGeneralSettingRegister'));
        add_action('customize_register', array($this,'sectionSetting'));
        
        // Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizePreviewJs' ), 0 );
    }


    /**
    * Add postMessage support for site title and description for the Theme Customizer.
    *
    * @param WP_Customize_Manager $wp_customize Theme Customizer object.
    */
    public function addPostMessageSupport($wp_customize) {

        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        
        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial( 'blogname', array(
                'selector'        => '.site-title a',
                'render_callback' => array($this,'partialBlogName'),
            ) );
            $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
                'selector'        => '.site-description',
                'render_callback' => array($this,'partialBlogDescription'),
            ) );
        }
    }

     /**
    * Add Theme Setting for (container theme, debugging) Theme Customizer.
    *
    * @param WP_Customize_Manager $wp_customize Theme Customizer object.
    */
    public function themeGeneralSettingRegister($wp_customize) {

        $nabCustomizer = new TeamDevCustomizer($wp_customize,'nabco');

        $nabCustomizer->addPanel('nabco_theme_setting_panel', 'Nabco Theme Setting','Theme General Setting',120);
        $nabCustomizer->addSection('nabco_theme_layout_option', 'Layout Section','Layout Setting',120,'nabco_theme_setting_panel');

        //container 
        $nabCustomizer->addSelectControl('nb_container',  [
            'default'   =>  'container',
            'type'      =>  'theme_mod',
            ],
            [
                'label'         =>  __('Template Container Type', 'nabco'),
                'section'   =>  'nabco_theme_layout_option',
                'choices'       => array(
                    'container'       => __( 'Container Fixed', 'nabco' ),
                    'container-full' => __( 'Container Full', 'nabco' ),
                ),
                'priority'  =>  '10'
            ]
        );
	
        //select for development and production mode
        $nabCustomizer->addSelectControl('nb_underconstruction',
            [
                'default'   =>  'development',
                'type'      =>  'theme_mod'
            ],
            [
                'label'         =>  __('Stage Type', 'nabco'),
                'section'   =>  'nabco_theme_layout_option',
                'choices'       => array(
                    'development'       => __( 'Development', 'nabco' ),
                    'stage' => __( 'Staging ', 'nabco' ),
                    'full_prod' => __( 'Full Production ', 'nabco' ),
                ),
                'priority'  =>  '20'
            ]
        );

        //select for development and production mode
        $nabCustomizer->addSelectControl('nb_theme_debug',  [
            'default'   =>  'false',
            'type'      =>  'theme_mod'],
            [
                'label'         =>  __('Theme Debug', 'nabco'),
                'section'   =>  'nabco_theme_layout_option',
                'choices'       => array(
                    'false'       => __( 'False', 'nabco' ),
                    'true' => __( 'True', 'nabco' ),
                ),
                'priority'  =>  '30'
            ]
        );

        $nabCustomizer->addSelectControl('nb_header_social_api',
			array('default'   =>  'none','type'		=>	'theme_mod'),
			array(
                'label'		=>	__('Social API'),
                'section'   =>  'nabco_theme_layout_option',
				'choices'	=>	array('none'=> 'None','basic' => 'Basic', 'general' => 'General'),
				'priority'	=>	20
			)
        );
        
        $nabCustomizer->addSelectControl('nb_header_search_control',
			array('default'   =>  'none','type'		=>	'theme_mod'),
			array(
                'section'   =>  'nabco_theme_layout_option',
				'label'		=>	__('Product Search'),
				'choices'	=>	array('none'=> 'None','product' => 'Product', 'basic' => 'Basic'),
				'priority'	=>	30
			)
		);
    }

    public function sectionSetting($wp_customize) {

        $nabCustomizer = new TeamDevCustomizer($wp_customize,'nabco');

        $nabCustomizer->addSection('nabco_slider_section_option', 'Slider Section','Slider Configuration',10,'nabco_theme_setting_panel');
        
        $nabCustomizer->addBasicControl('slider_speed','text',
            array('default'   =>  '0','type'		=>	'theme_mod'),
            array('label' => __('Slider Speed'),'priority' => 10,'section' => 'nabco_slider_section_option')
        );

        $nabCustomizer->addBasicControl('slider_count','text',
            array('default'   =>  '4','type'		=>	'theme_mod'),
            array('label' => __('Sliders'),'priority' => 20,'section' => 'nabco_slider_section_option')
        );

        $nabCustomizer->addSelectControl('slider_animation',
			array('default'   =>  'slide','type'		=>	'theme_mod'),
			array(
                'section'   =>  'nabco_slider_section_option',
				'label'		=>	__('Animation'),
				'choices'	=>	array('slide'=> 'Slide','fade' => 'Fading'),
				'priority'	=>	30
			)
        );
        
        $nabCustomizer->addSection('nabco_promotion_section_option', 'Promotion Section','Promotion Configuration',20,'nabco_theme_setting_panel');

        $nabCustomizer->addBasicControl('promotion_title','text',
            array('default'   =>  '','type'		=>	'theme_mod'),
            array('label' => __('Title'),'priority' => 10)
        );

        $nabCustomizer->addSelectControl('promotion_view_type',
			array('default'   =>  'hide','type'		=>	'theme_mod'),
			array(
				'label'		=>	__('Display Promotion'),
				'choices'	=>	array('review'=> 'Review','live' => 'Live', 'hide' => 'Hide'),
				'priority'	=>	20
			)
        );

        $pages = get_pages();
        $choices = array();
        
        if($pages) {
            
            $choices['none'] = '--Select Page--';
            
            foreach($pages as $page) {
                $choices[get_page_link($page->ID)] =  $page->post_title;
            }
            
            $nabCustomizer->addSelectControl('promotion_page_link',
                array('default'   =>  'none','type'		=>	'theme_mod'),
                array(
                    'label'		=>	__('Promotion Page'),
                    'choices'	=>	$choices,
                    'priority'	=>	30
                )
            );
        }

        $nabCustomizer->addBasicControl('promotion_limit','text',
            array('default'   =>  '7','type'		=>	'theme_mod'),
            array('label' => __('Limit'),'priority' => 40)
        );

        $nabCustomizer->addSelectControl('promotion_orderby',
        array('default'   =>  'date','type'		=>	'theme_mod'),
        array(
            'label'		=>	__('Display Promotion'),
            'choices'	=>	array(
                                'date'=> 'Date',
                                'menu_order' => 'Order', 
                                'popularity' => 'Popularity', 
                                'rating' => 'Rating', 
                                'title' => 'Title'),
            'priority'	=>	50
        ));

        $nabCustomizer->addBasicControl('promotion_css','text',
            array('default'   =>  'front-view','type'		=>	'theme_mod'),
            array('label' => __('Css Class'),'priority' => 40)
        );

        $nabCustomizer->addSection('nabco_testimony_section_option', 'Testimony Section','Testimony Configuration',30,'nabco_theme_setting_panel');
        
        $nabCustomizer->addUploadControl('testimony_background',
            array('default' => '','type' => 'theme_mod'),
            array(
                    'label'         => __('Add Background'),
                    'description'   =>  __('Maximum 1MB Recommended Size (2100 x 500)'),
                    'priority'      => 10));


    }

    
        

    /**
     * Render the site title for the selective refresh partial.
     *
     * @return void
     */
    public function partialBlogName() {
        bloginfo( 'name' );
    }
    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    public function partialBlogDescription() {
        bloginfo( 'description' );
    }

    
    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    public function customizePreviewJs() {
        wp_enqueue_script( 'nabco-furnitures-customizer', get_template_directory_uri() . '/dist/js-admin/customizer.js', array( 'customize-preview' ), '20151215', true );
    }
}

return new Nab_Customizer();