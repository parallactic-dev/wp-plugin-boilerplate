<?php

class Parallactic_Meta {

	public function __construct() {
        add_action('acf/init', array($this, 'add_custom_fields'));
        add_action('rest_api_init', array($this, 'register_rest_endpoints'));
        add_action('init', array($this, 'register_menues'), 100);
        add_action('preview_post_link', array($this, 'preview_fix'), 10, 2);

        $this->add_image_sizes();

	}
    
    public function add_custom_fields() 
    {
        if (!function_exists('acf_add_local_field_group')) return;
        
        acf_add_local_field_group(array(
            'key' => 'group_meta',
            'title' => __('Meta Information', 'parallactic'),
            'fields' => array(
                array(
                    'key' => 'meta_title',
                    'label' => __('Meta Title', 'parallactic'),
                    'name' => 'meta_title',
                    'type' => 'text',
                    'instructions' => __('Leave this field empty if it should be the same as the page title', 'parallactic'),
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
                    'key' => 'meta_description',
                    'label' => __('Meta Description', 'parallactic'),
                    'name' => 'meta_description',
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
                    'key' => 'meta_image',
                    'label' => __('Preview Image', 'parallactic'),
                    'name' => 'meta_image',
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
                    'key' => 'meta_exclude_from_sitemap',
                    'label' => __('Sitemap', 'parallactic'),
                    'name' => 'meta_exclude_from_sitemap',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => __('Exclude from sitemap', 'parallactic'),
                    'default_value' => 0,
                    'ui' => 0,
                    'translations' => 'copy_once',
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
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
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'person',
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

    // register menus
    public function register_menues()
    {
        register_nav_menu('main', 'Header');
        register_nav_menu('footer', 'Footer');
    }

    public function register_rest_endpoints()
    {
        register_rest_route('wp/v2', 'menus', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_menus'),
            'permission_callback' => '__return_true',
        ));
        register_rest_route('wp/v2', 'meta', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_meta'),
            'permission_callback' => '__return_true',
        ));
        register_rest_route('wp/v2', 'sitemap', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_sitemap'),
            'permission_callback' => '__return_true',
        ));
    }

    public function get_menus()
    {
        $locations = get_nav_menu_locations();
        $menus = array();
        // loop all menus
        foreach ($locations as $key => $location) {
            $object = wp_get_nav_menu_object($location);
            $menu_items = wp_get_nav_menu_items($object->slug);
            $menu = array();
            // loop all items
            foreach ($menu_items as $menu_item) {
                $menu_item->url = str_replace(get_home_url(), '', $menu_item->url);
                // add slug if post
                if ($menu_item->object !== 'custom') {
                    $menu_item->slug = get_post_field('post_name', $menu_item->object_id);;
                }
                // if has parent
                if ($menu_item->menu_item_parent > 0) {
                    $i = $this->_get_index_of_menu_item($menu, $menu_item->menu_item_parent);
                    if ($i !== false) {
                        $menu[$i]['menu_item_children'][] = $menu_item->to_array();
                    }
                } 
                // add to menu
                else {
                    $menu[] = $menu_item->to_array();
                }
            }
            $menus[$key] = $menu;
        }
        return $menus;
    }

    private function _get_index_of_menu_item($array, $ID)
    {
        foreach ($array as $key => $item) {
            if ($item['ID'] == $ID)
                return $key;
        }
        return false;
    }

    public function get_meta()
    {
        $meta = array();
        $fields = array(
            'url', 
            'version', 
            'text_direction', 
            'language',
        );
        foreach($fields as $field) {
            $meta[$field] = get_bloginfo($field);
        }

        $fields = array(
            'blogname', 
            'blogdescription', 
            'blog_charset', 
            'html_type', 
            'date_format',
            'time_format',
            'show_on_front',
            'posts_per_page',
            'permalink_structure'
        );
        foreach($fields as $field) {
            $meta[$field] = get_option($field);
        }

        //  fields from custom options page
        $meta['footer'] = get_field('footer', 'option');
        $meta['cookie_banner'] = get_field('cookie_banner', 'option');
        
        return new WP_REST_Response($meta, 200);
    }

    public function get_sitemap() 
    {
        $posts = get_posts([
            'post_type' => array('page', 'post'),
            'post_status' => array('publish'),
            'numberposts' => -1,
            'meta_key' => 'meta_exclude_from_sitemap',
            'meta_value' => 0,
            'orderby' => 'title',
            'order' => 'ASC'
        ]);

        $map = array();
        foreach ($posts as $post) {
            $url = str_replace(get_home_url(), '', get_permalink($post->ID));
            $map[$post->post_type][] = array( 
                'url' => $url, 
                'lastmod' => date('c', strtotime($post->post_modified_gmt)) 
            );
        }

        return new WP_REST_Response($map, 200);
    }

    public function preview_fix($link, $post) {
        $slug = basename(get_permalink());
        return get_home_url() . "/preview/$post->ID";
    }

    private function add_image_sizes() {
        add_image_size('xl', 1280, 1440, false);
    }

}
