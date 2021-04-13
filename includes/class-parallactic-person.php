<?php

class Parallactic_Person {

	public function __construct() 
    {
        add_action('init', array($this, 'add_custom_posttype'));
        add_action('acf/init', array($this, 'add_custom_fields'));
        add_filter('rest_person_query', array($this, 'set_query_params'), 10, 1);
	}

    public function add_custom_posttype() 
    {    
        $labels = [
            'name' => __('People', 'parallactic'),
            'singular_name' => __('Person', 'parallactic'),
            'menu_name' => __('People', 'parallactic'),
            'all_items' => __('All People', 'parallactic'),
            'add_new' => __('Add New', 'parallactic'),
            'add_new_item' => __('Add New Person', 'parallactic'),
            'edit_item' => __('Edit Person', 'parallactic'),
            'new_item' => __('New Person', 'parallactic'),
            'view_item' => __('View Person', 'parallactic'),
            'view_items' => __('View People', 'parallactic'),
            'search_items' => __('Search People', 'parallactic'),
            'not_found' => __('No Person found', 'parallactic'),
            'not_found_in_trash' => __('No Person found in Trash', 'parallactic'),
            'parent' => __('Parent Person', 'parallactic'),
            'featured_image' => __('Featured image for this person', 'parallactic'),
            'set_featured_image' => __('Set featured image for this person', 'parallactic'),
            'remove_featured_image' => __('Remove featured image for this person', 'parallactic'),
            'use_featured_image' => __('Use as feature image for this person', 'parallactic'),
            'archives' => __('People Archives', 'parallactic'),
            'insert_into_item' => __('Insert into person', 'parallactic'),
            'uploaded_to_this_item' => __('Upload to this person', 'parallactic'),
            'filter_items_list' => __('Filter people list', 'parallactic'),
            'items_list_navigation' => __('People list navigation', 'parallactic'),
            'items_list' => __('People list', 'parallactic'),
            'attributes' => __('People Attributes', 'parallactic'),
            'name_admin_bar' => __('Person', 'parallactic'),
            'item_published' => __('Person published', 'parallactic'),
            'item_published_privately' => __('Person published privately', 'parallactic'),
            'item_reverted_to_draft' => __('Person reverted to draft', 'parallactic'),
            'item_scheduled' => __('Person scheduled', 'parallactic'),
            'item_updated' => __('Person updated', 'parallactic'),
            'parent_item_colon' => __('Parent Person', 'parallactic'),
        ];
    
        $args = [
            'label' => __('People', 'parallactic'),
            'labels' => $labels,
            'description' => '',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'rest_base' => 'people',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'delete_with_user' => false,
            'exclude_from_search' => false,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'hierarchical' => false,
            'rewrite' => [ 'slug' => 'person', 'with_front' => true ],
            'query_var' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-groups',
            'supports' => [ 'title', 'thumbnail', 'revisions', 'custom-fields' ],
        ];
    
        register_post_type('person', $args);
    }
    
    public function add_custom_fields() {
        if (!function_exists('acf_add_local_field_group')) return;

        acf_add_local_field_group(array(
            'key' => 'person_group',
            'title' => __('Person', 'parallactic'),
            'fields' => array(
                array(
                    'key' => 'person_name',
                    'label' => __('Name', 'person'),
                    'name' => 'name',
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
                    'key' => 'person_role',
                    'label' => __('Role', 'person'),
                    'name' => 'role',
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
                    'key' => 'person_biography',
                    'label' => __('Biography', 'person'),
                    'name' => 'biography',
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
                array(
                    'key' => 'person_portrait',
                    'label' => __('Portrait', 'parallactic'),
                    'name' => 'portrait',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
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
                    'key' => 'person_email',
                    'label' => __('Email', 'person'),
                    'name' => 'e-mail',
                    'type' => 'email',
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
                    'key' => 'person_phone',
                    'label' => __('Phone', 'person'),
                    'name' => 'phone',
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
                    'key' => 'person_linkedin',
                    'label' => __('LinkedIn', 'person'),
                    'name' => 'linkedin',
                    'type' => 'url',
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
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'person',
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
        ));
    }

    public function set_query_params($args) 
    {
        if (isset( $_REQUEST['per_page']))
            return $args;

        $args['posts_per_page'] = 1000;
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
        
        return $args;
    }
}
