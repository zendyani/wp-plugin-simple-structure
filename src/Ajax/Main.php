<?php

namespace Wap\Ajax;

class Main
{
    public function handler()
    {
        try {
            check_ajax_referer(WAP_NONCE_NAME, 'nonce');

            $name = sanitize_text_field($_POST['name']);
            echo 'Hello, ' . esc_html($name) . '!';

        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }

        wp_die();
    }
}