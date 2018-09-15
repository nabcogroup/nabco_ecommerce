<?php

class TeamDevCustomizer {

    protected $wp_customize;
    protected $domain;
    protected $section_name;

    public function __construct(&$wp_customize,$domain) {
        
        $this->wp_customize = $wp_customize;
        $this->domain = $domain;
        
    }
    
    public function addSection($sectionId, $title,$description,$priority,$panel = '') {
        $args = array(
            'title'       => __( $title, $this->domain),
            'description' => __( $description, $this->domain ),
            'priority'    => $priority,
        );
        $this->section_name = $sectionId;
        
        if(!empty($panel)) {
            $args['panel'] = $panel;
        }

        $this->wp_customize->add_section($this->section_name, $args);

    }

    public function addPanel($id,$title,$description,$priority) {

        $this->wp_customize->add_panel( $id, array(
                'priority'       => $priority,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => __($title),
                'description'    => __($description),
           ) );
    }

    public function addSelectControl($name,$settings = [],$controls = [],$override = false) {
        
        $default_control_setting = [
            'label'         =>  isset($controls['label']) ? $controls['label'] : '',
            'description'   =>  isset($controls['description']) ? $controls['description'] : '',
            'section'       =>  isset($controls['section']) ? $controls['section'] : $this->section_name,
            'type'          =>  'select',
            'priority'      =>  isset($controls['priority']) ? $controls['priority'] : '',
            'choices'       =>  isset($controls['choices']) ? $controls['choices'] : '',
        ];

        $this->wp_customize->add_setting( $name, $settings);
        
        $this->wp_customize->add_control($name,$default_control_setting);

    }

    public function addBasicControl($name,$type = 'text', $settings = [],$controls = [],$override = false) {
        
        $default_control_setting = [
            'label'         =>  isset($controls['label']) ? $controls['label'] : '',
            'description'   =>  isset($controls['description']) ? $controls['description'] : '',
            'section'       =>  isset($controls['section']) ? $controls['section'] : $this->section_name,
            'type'          =>  $type,
            'priority'      =>  isset($controls['priority']) ? $controls['priority'] : '',
            'input_attrs'   =>  isset($controls['input_attrs']) ? $controls['input_attrs'] : [],
        ];
        
        $this->wp_customize->add_setting( $name, $settings);

        $this->wp_customize->add_control($name,$default_control_setting);
        
    }

    public function addCoreControl($name,$settings = array(),$controls = array(),$override = false) {
        
        $default_control_setting = [
            'label'         =>  '',
            'description'   =>  '',
            'section'       =>  isset($controls['section']) ? $controls['section'] : $this->section_name,
            'type'          =>  'text',
            'priority'      =>  '10'
        ];

        foreach($default_control_setting as $key => $value) {
            if(isset($controls[$key])) {
                $default_control_setting[$key] = $controls[$key];
            }
        }
        
        $this->wp_customize->add_setting( $name, $settings);

        $this->wp_customize->add_control(new WP_Customize_Control($this->wp_customize,$name,$default_control_setting));
    } 

    public function addUploadControl($name,$settings = array(),$controls = array(),$override = false) {
        
        $default_control_setting = [
            'label'         =>  isset($controls['label']) ? __($controls['label']) : '',
            'description'   =>  isset($controls['description']) ? __($controls['description']) : '',
            'section'       =>  isset($controls['section']) ? $controls['section'] : $this->section_name,
            'priority'      =>  isset($controls['priority']) ? $controls['priority'] : '',
            'input_attrs'   =>  isset($controls['input_attrs']) ? $controls['input_attrs'] : [],
        ];

        $this->wp_customize->add_setting( $name, $settings);

        $this->wp_customize->add_control(new WP_Customize_Upload_Control( $this->wp_customize,  $name, $default_control_setting));
    }
}