<?php

class Parallactic_ACF_REST
{

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'acf2api_hook_all_post_types'), 99);

    }

    /**
     * This function will modify the REST response and add the custom fields
     *
     * @since 	   1.0.0
     */
    public function acf2api_hook_all_post_types()
    {
        //Get all the post types
        global $wp_post_types;
        $post_types = array_keys($wp_post_types);

        //Loop through each one
        foreach ($post_types as $post_type) {

            //Add a filter for this post type
            add_filter('rest_prepare_' . $post_type, function ($data, $post, $request) {
                //Get the response data
                $response_data = $data->get_data();

                //Bail early if there's an error
                if ($request['context'] !== 'view' || is_wp_error($data)) {
                    return $data;
                }

                // $response_data = array_merge($response_data, $this->add_acf_fields($post->ID));
                $response_data['acf'] = $this->add_acf_fields($post->ID);

                //Commit the API result var to the API endpoint
                $data->set_data($response_data);
                return $data;
            }, 10, 3);
        }
    }

    /**
     * This function will modify the REST response and add the custom fields
     *
     * @since 	   1.0.0
     */
    protected function add_acf_fields($post_id)
    {
        $returnData = array();
        $fields = get_fields($post_id);

        if ($fields) {
            $returnData = $this->loop_children($fields);
        }

        return $returnData;
    }

    protected function loop_children($item)
    {
        $return_value = array();
        foreach ($item as $key => $value) {
            // loop children of array
            if (gettype($value) === 'array') {
                $return_value[$key] = $this->loop_children($value);
            }

            // get fileds if a wp_post
            elseif (gettype($value) === 'object' && get_class($value) === 'WP_Post') {
                $return_value[$key] = array_merge($value->to_array(), $this->add_acf_fields($value->ID));
            }

            // else return just plain data
            else {
                if ($key !== 'private_value') {
                    $return_value[$key] = $value;
                }
            }
        }

        return $return_value;
    }
}
