<?php

class Parallactic_Page {
    private $acf_rest;

	public function __construct() {
        add_action('acf/init', array($this, 'add_custom_fields'));
        add_action('rest_api_init', array($this, 'register_rest_endpoints'));

        $this->acf_rest = new Parallactic_ACF_REST();
    
	}
    
    public function add_custom_fields() {
        if (!function_exists('acf_add_local_field_group')) return;

        acf_add_local_field_group(array(
            'key' => 'group_page_content',
            'title' => __('Page Content', 'parallactic'),
            'fields' => array(
                array(
                    'key' => 'field_page_content',
                    'label' => __('Content Blocks', 'parallactic'),
                    'name' => 'page_content',
                    'type' => 'flexible_content',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layouts' => array(
                        'layout_page_text_block' => array(
                            'key' => 'layout_page_text_block',
                            'name' => 'text_block',
                            'label' => __('Text Block', 'parallactic'),
                            'display' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_page_text_block_text',
                                    'label' => __('Text', 'parallactic'),
                                    'name' => 'text',
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
                                    'toolbar' => 'full',
                                    'media_upload' => 1,
                                    'delay' => 0,
                                ),
                            ),
                            'min' => '',
                            'max' => '',
                        ),
                        'layout_page_image_block' => array(
                            'key' => 'layout_page_image_block',
                            'name' => 'image_block',
                            'label' => __('Image', 'parallactic'),
                            'display' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_page_image_block_image',
                                    'label' => __('Image', 'parallactic'),
                                    'name' => 'image',
                                    'type' => 'image',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'array',
                                    'preview_size' => 'medium',
                                    'library' => 'all',
                                    'min_width' => '',
                                    'min_height' => '',
                                    'min_size' => '',
                                    'max_width' => '',
                                    'max_height' => '',
                                    'max_size' => '',
                                    'mime_types' => '',
                                ),
                                array(
                                    'key' => 'field_page_image_block_caption',
                                    'label' => __('Caption', 'parallactic'),
                                    'name' => 'caption',
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
                            ),
                            'min' => '',
                            'max' => '',
                        ),
                        'layout_page_contact_form' => array(
                            'key' => 'layout_page_contact_form',
                            'name' => 'contact_form',
                            'label' => __('Contact Form', 'parallactic'),
                            'display' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_page_contact_form_title',
                                    'label' => __('Form Title', 'parallactic'),
                                    'name' => 'title',
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
                                ),
                                array(
                                    'key' => 'field_page_contact_form_email',
                                    'label' => __('Email Receiver', 'parallactic'),
                                    'name' => 'email_to',
                                    'type' => 'email',
                                    'instructions' => '',
                                    'required' => 1,
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
                                ),
                                array(
                                    'key' => 'field_page_contact_form_button_label',
                                    'label' => __('Button Label', 'parallactic'),
                                    'name' => 'button_label',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => 'Submit',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                ),
                                array(
                                    'key' => 'field_page_contact_form_confirm_message',
                                    'label' => __('Confirm Message', 'parallactic'),
                                    'name' => 'confirm_message',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 1,
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
                                ),
                                array(
                                    'key' => 'field_page_contact_form_fields',
                                    'label' => __('Form Fields', 'parallactic'),
                                    'name' => 'fields',
                                    'type' => 'repeater',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'collapsed' => '',
                                    'min' => 0,
                                    'max' => 0,
                                    'layout' => 'block',
                                    'button_label' => __('Add Field', 'parallactic'),
                                    'sub_fields' => array(
                                        array(
                                            'key' => 'field_page_contact_form_label',
                                            'label' => __('Field Label', 'parallactic'),
                                            'name' => 'label',
                                            'type' => 'text',
                                            'instructions' => '',
                                            'required' => 1,
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
                                            'key' => 'field_page_contact_form_type',
                                            'label' => __('Field Type', 'parallactic'),
                                            'name' => 'type',
                                            'type' => 'select',
                                            'instructions' => '',
                                            'required' => 1,
                                            'conditional_logic' => 0,
                                            'wrapper' => array(
                                                'width' => '',
                                                'class' => '',
                                                'id' => '',
                                            ),
                                            'choices' => array(
                                                'text' => __('Text', 'parallactic'),
                                                'number' => __('Number', 'parallactic'),
                                                'email' => __('Email', 'parallactic'),
                                                'tel' => __('Phone Number', 'parallactic'),
                                                'textarea' => __('Textarea', 'parallactic'),
                                            ),
                                            'default_value' => 'text',
                                            'allow_null' => 0,
                                            'multiple' => 0,
                                            'ui' => 0,
                                            'return_format' => 'value',
                                            'ajax' => 0,
                                            'placeholder' => '',
                                        ),
                                        array(
                                            'key' => 'field_page_contact_form_mandatory',
                                            'label' => __('Mandatory', 'parallactic'),
                                            'name' => 'mandatory',
                                            'type' => 'true_false',
                                            'instructions' => '',
                                            'required' => 0,
                                            'conditional_logic' => 0,
                                            'wrapper' => array(
                                                'width' => '',
                                                'class' => '',
                                                'id' => '',
                                            ),
                                            'message' => __('Make this field mandatory', 'parallactic'),
                                            'default_value' => 0,
                                            'ui' => 0,
                                            'ui_on_text' => '',
                                            'ui_off_text' => '',
                                        ),
                                        array(
                                            'key' => 'field_page_contact_form_validation',
                                            'label' => __('Validation Message', 'parallactic'),
                                            'name' => 'validation_message',
                                            'type' => 'text',
                                            'instructions' => '',
                                            'required' => 0,
                                            'conditional_logic' => array(
                                                array(
                                                    array(
                                                        'field' => 'field_page_contact_form_mandatory',
                                                        'operator' => '==',
                                                        'value' => '1',
                                                    ),
                                                ),
                                            ),
                                            'wrapper' => array(
                                                'width' => '',
                                                'class' => '',
                                                'id' => '',
                                            ),
                                            'default_value' => 'Please enter a value',
                                            'placeholder' => '',
                                            'prepend' => '',
                                            'append' => '',
                                            'maxlength' => '',
                                        ),
                                    ),
                                ),
                            ),
                            'min' => '',
                            'max' => '',
                        ),
                        'layout_page_people_overview' => array(
                            'key' => 'layout_page_people_overview',
                            'name' => 'people_overview',
                            'label' => __('People Overview', 'parallactic'),
                            'display' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_page_people_overview_people',
                                    'label' => __('People', 'parallactic'),
                                    'name' => 'people',
                                    'type' => 'repeater',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'collapsed' => '',
                                    'min' => 0,
                                    'max' => 0,
                                    'layout' => 'table',
                                    'button_label' => __('Add Person', 'parallactic'),
                                    'sub_fields' => array(
                                        array(
                                            'key' => 'field_page_people_overview_person',
                                            'label' => __('Person', 'parallactic'),
                                            'name' => 'person',
                                            'type' => 'post_object',
                                            'instructions' => '',
                                            'required' => 0,
                                            'conditional_logic' => 0,
                                            'wrapper' => array(
                                                'width' => '',
                                                'class' => '',
                                                'id' => '',
                                            ),
                                            'post_type' => array(
                                                0 => 'person',
                                            ),
                                            'taxonomy' => '',
                                            'allow_null' => 0,
                                            'multiple' => 0,
                                            'return_format' => 'object',
                                            'ui' => 1,
                                        ),
                                    ),
                                ),
                            ),
                            'min' => '',
                            'max' => '',
                        ),
                    ),
                    'button_label' => __('Add Content Block', 'parallactic'),
                    'min' => '',
                    'max' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                // 1 => 'excerpt',
                // 2 => 'discussion',
                // 3 => 'comments',
                // 4 => 'author',
                // 5 => 'format',
                // 6 => 'page_attributes',
                // 7 => 'featured_image',
                // 8 => 'categories',
                // 9 => 'tags',
                // 10 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
        ));

    }

    public function register_rest_endpoints()
    {
        register_rest_route('wp/v2', 'frontpage', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_frontpage'),
            'permission_callback' => '__return_true',
        ));
    }

    public function get_frontpage()
    {
        $post_id = get_option('page_on_front');    
        $post = $post_id > 0 ? get_post($post_id) : null;  

        if (!is_a($post, '\WP_Post')) {
            return new WP_Error('frontpage', 'No static page set.', array('status' => 404));
        }

        $post = $post->to_array();
        $post['fields'] = $this->acf_rest->add_acf_fields($post_id);

        return new WP_REST_Response($post, 200);
    }

}
