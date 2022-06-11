<?php

class Parallactic_Security {

	public function __construct() {
        add_action('rest_api_init', array($this, 'register_rest_endpoints'));

        // diable rss feed
        add_action('do_feed', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_rdf', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_rss', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_rss2', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_atom', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_rss2_comments', array($this, 'disable_rss_feed'), 1);
        add_action('do_feed_atom_comments', array($this, 'disable_rss_feed'), 1);

        // remove user from oembed json
        add_filter( 'oembed_response_data', array($this, 'filter_oembed_response_data_author'), 10, 4 );

        // disable sitemap generation
        add_filter('wp_sitemaps_enabled', '__return_false');

        // disable robots.txt generation
        add_filter('robots_txt', '__return_false');
	}

    public function register_rest_endpoints()
    {
        // disable user endpoint
        register_rest_route('wp/v2', 'users', array(
            'methods' => 'GET',
            'callback' => function() {return;},
            'permission_callback' => '__return_true',
        ));
    }

    public function filter_oembed_response_data_author($data, $post, $width, $height)
    {
        unset($data['author_name']);
        unset($data['author_url']);
        return $data;
    }

    public function disable_rss_feed() {
        wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
    }

}
