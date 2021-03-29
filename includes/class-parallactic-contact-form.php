<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Parallactic_Contact_Form {

    public function __construct() 
    {
        add_action('rest_api_init', array($this, 'register_rest_endpoint'));

        // dont send value of email field
        add_filter('acf/load_value/key=field_page_contact_form_email', array($this, 'hide_email_field'), 1, 3);

    }
    
    public function register_rest_endpoint()
    {
        register_rest_route('wp/v2', 'contact-forms', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_post_request'),
            'permission_callback' => '__return_true',
            // 'permission_callback' => function(WP_REST_Request $request) {
            //     return wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest');
            // },
        ));
    }

    public function handle_post_request(WP_REST_Request $request)
    {
        $request_data = $request->get_json_params();

        $post_id = $request_data['post_id'];
        $field_content = $request_data['parent'];
        $field_key = $request_data['key'];

        // get fields from form
        $fields = array();
        $email_to = '';
        $layouts = get_field($field_content, $post_id);
        if ($layouts && is_array($layouts)) {
            foreach ($layouts as $layout_data) {
                // look for the form block
                if ($layout_data['acf_fc_layout'] === 'contact_form' 
                    && isset($layout_data['email_to'])
                    && isset($layout_data['email_to']['key'])
                    && $layout_data['email_to']['key'] === $field_key) 
                {
                    $fields = $layout_data['fields'];

                    // get reciever email
                    if (isset($layout_data['email_to'])
                        && $layout_data['email_to']['private_value']) 
                    {
                        $email_to = $layout_data['email_to']['private_value'];
                    } else {
                        return new WP_Error('contact_form_no_email_to', 'No reciever email address set.', array('status' => 403));
                    }
                    
                    // break loop when found
                    break;
                }
            } 
        }

        // create email body from fields
        $message = '';
        if ($fields) {
            $message .= __('Message from contact form from', 'parallactic') . ' ' . get_bloginfo('name') . ": \r\n\n";
            foreach ($fields as $field) {
                $field_name = strtolower(str_replace(' ', '-', $field['label']));
                if (isset($request_data['fields'][$field_name])) {
                    $requst_field = $request_data['fields'][$field_name];
                    $message .= $field['label'] . ': ' . $requst_field . "\r\n";
                } else {
                    if (!$field['mandatory']) {
                        $message .= $field['label'] . ": – \r\n";
                    } else {
                        return new WP_Error('contact_form_missing_madatory_field', 'Missing madatory field "' . $field_name . '".', array('status' => 403));
                    }
                }
            }
        } else {
            return new WP_Error('contact_form_no_fields', 'No fields found.', array('status' => 403));
        }
        
        // create and send email
        $mail = new PHPMailer(true);
        $subject = __('Contact Form via', 'parallactic') . ' ' . get_bloginfo('url');

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();         
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['SMTP_PORT'];

            //Recipients
            $mail->setFrom(get_bloginfo('admin_email'), get_bloginfo('name'));
            $mail->addAddress($email_to);
            $mail->addReplyTo($email_to);

            //Content
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
        } catch (Exception $e) {
            return new WP_Error('contact_form_send_error', 'Email send error.', array('status' => 500));
        }


        return new WP_REST_Response('success', 200);
    }

    public function hide_email_field($value, $post_id, $field) 
    {
        if (!is_admin()) {
            return array(
                'private_value' => $value,
                'post_id' => $post_id,
                'parent' => $field['parent'],
                'key' => $field['name'],
            );
        } else {
            return $value;
        }
    }
    

}
