<?php
/**
 * nabcofurn_us Theme Customizer
 *
 * @package nabcofurn_us
 */



/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nabco_furnitures_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'nabco_furnitures_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'nabco_furnitures_customize_partial_blogdescription',
		) );
	}
}


add_action( 'customize_register', 'nabco_furnitures_customize_register' );



/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nabco_furnitures_theme_customize_register($wp_customize) {

	$nabCustomizer = new TeamDevCustomizer($wp_customize,'nabco','nabco_theme_layout_option');

	$nabCustomizer->addSection('Naco Theme Setting','Theme General Setting',120);

	$nabCustomizer->addSelectControl('nb_container',  [
        'default'   =>  'container',
        'type'      =>  'theme_mod'],
        [
            'label'         =>  __('Template Container Type', 'nabco'),
            'choices'       => array(
                'container'       => __( 'Container Fixed', 'nabco' ),
                'container-full' => __( 'Container Full', 'nabco' ),
            ),
            'priority'  =>  '10'
        ]
	);
	

	$nabCustomizer->addSelectControl('nb_underconstruction',  [
        'default'   =>  'development',
        'type'      =>  'theme_mod'],
        [
			'label'         =>  __('Stage Type', 'nabco'),
			
            'choices'       => array(
                'development'       => __( 'Development', 'nabco' ),
				'stage' => __( 'Staging ', 'nabco' ),
				'full_prod' => __( 'Full Production ', 'nabco' ),
			),

            'priority'  =>  '20'
        ]
	);


	$argUploadSetting = array(
		'default'   =>  '',
		'type'		=>	'theme_mod'
	);
	
	$argUploadControl = array('label' => 'Upload Video');

	$nabCustomizer->addUploadControl('nb_upload_video',$argUploadSetting,$argUploadControl);


}

add_action( 'customize_register', 'nabco_furnitures_theme_customize_register');





/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nabco_furnitures_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nabco_furnitures_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nabco_furnitures_customize_preview_js() {
	wp_enqueue_script( 'nabco-furnitures-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'nabco_furnitures_customize_preview_js' );
