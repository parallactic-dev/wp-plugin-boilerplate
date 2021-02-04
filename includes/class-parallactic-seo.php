<?php

class Parallactic_SEO {

	public function __construct() {
        add_action('acf/init', array($this, 'add_custom_fields'));

	}
    
    public function add_custom_fields() 
    {
        if (!function_exists('acf_add_local_field_group')) return;
        
        acf_add_local_field_group(array(
            'key' => 'group_seo',
            'title' => 'Meta Data',
            'fields' => array(
                array(
                    'key' => 'seo_title',
                    'label' => 'Meta Title',
                    'name' => 'seo_title',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'seo_description',
                    'label' => 'Meta Description',
                    'name' => 'seo_description',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                // array(
                //     'key' => 'seo_include_in_sitemap',
                //     'label' => 'SEO Include in Sitemap',
                //     'name' => 'seo_include_in_sitemap',
                //     'type' => 'true_false',
                //     'instructions' => '',
                //     'required' => 0,
                //     'conditional_logic' => 0,
                //     'wrapper' => array(
                //         'width' => '',
                //         'class' => '',
                //         'id' => '',
                //     ),
                //     'message' => 'Include',
                //     'default_value' => 1,
                //     'ui' => 0,
                //     'translations' => 'copy_once',
                //     'ui_on_text' => '',
                //     'ui_off_text' => '',
                // ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                ),
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                ),
            ),
            'menu_order' => 99,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

    }

}
