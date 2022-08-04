<?php

class Parallactic_Options {

	public function __construct() {
        add_action('acf/init', array($this, 'add_options_page'));
        add_action('acf/init', array($this, 'add_custom_fields'));

	}

    public function add_options_page()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page(array(
                'page_title' 	=> 'Frontend Options',
                'menu_title'	=> 'Frontend',
                'menu_slug' 	=> 'settings-sfrontend',
                'capability'	=> 'manage_options',
                'redirect'		=> false,
                'parent_slug'   => 'options-general.php'
            ));
        }
    }

    public function add_custom_fields()
    {
        if (!function_exists('acf_add_local_field_group')) return;
        
        acf_add_local_field_group(array(
            'key' => 'group_62ebc297ca03a',
            'title' => 'General',
            'fields' => array(
                array(
                    'key' => 'field_62ebc44fd8f3a',
                    'label' => 'Footer',
                    'name' => 'footer',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_62ebc2a0745c0',
                    'label' => 'Cookie Banner',
                    'name' => 'cookie_banner',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                    'delay' => 0,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'settings-salzandwater',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));
    }
    
}
