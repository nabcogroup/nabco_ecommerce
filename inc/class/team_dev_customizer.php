<?php

class TeamDevCustomizer {

    protected $wp_customize;
    protected $domain;
    protected $section_name;

    public function __construct(&$wp_customize,$domain,$section_name) {
        
        $this->wp_customize = $wp_customize;
        $this->domain = $domain;
        $this->section_name = $section_name;

    }

    public function addSection($title,$description,$priority) {
        
        $this->wp_customize->add_section($this->section_name, array(
            'title'       => __( $title, $this->domain),
            'description' => __( $title, 'understrap' ),
            'priority'    => $priority,
        ));

    }

    public function addSelectControl($name,$settings = [],$controls = [],$override = false) {
        
        $default_control_setting = [
            'label'         =>  isset($controls['label']) ? $controls['label'] : '',
            'description'   =>  isset($controls['description']) ? $controls['description'] : '',
            'section'       =>  $this->section_name,
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
            'section'       =>  $this->section_name,
            'type'          =>  $type,
            'priority'      =>  isset($controls['priority']) ? $controls['priority'] : '',
            'input_attrs'   =>  isset($controls['input_attrs']) ? $controls['input_attrs'] : [],
        ];
        
        $this->wp_customize->add_setting( $name, $settings);

        $this->wp_customize->add_control($name,$default_control_setting);
        
    }

    public function addCoreControl($name,$settings = [],$controls = [],$override = false) {
        
        $default_control_setting = [
            'label'         =>  '',
            'description'   =>  '',
            'section'       =>  $this->section_name,
            'type'          =>  'text',
            'priority'      =>  '10'
        ];

        foreach($default_control_setting as $key => $value) {
            if(isset($controls[$key])) {
                $default_control_setting[$key] = $controls[$key];
            }
        }
        
        $this->wp_customize->add_setting( $name, $settings);

        $this->wp_customize->add_control(new WP_Customize_Control($wp_customize,$name,$default_control_setting));
    }
}