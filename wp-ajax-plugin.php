<?php
use Wap\Router\Router;

/**
 * Plugin Name: WP AJAX Plugin
 * Description: A simple AJAX example for WordPress.
 * Version: 1.0
 * Author: Your Name here
 * Text Domain: wp-ajax-plugin
 */

// Load Composer dependencies
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Prevent direct access
defined('ABSPATH') or die('No script kiddies please!');

define('WAP_PATH', plugin_dir_path(__FILE__));
define('WAP_URL', plugin_dir_url(__FILE__));
define('WAP_VIEW_PATH', WAP_PATH . 'src/View');

class MyAjaxPlugin
{
    private Router $router;

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init(): void
    {
        $this->defineConstants();
        $this->setupRouter();
    }

    private function defineConstants(): void
    {
        define('WAP_NONCE_NAME', 'my-ajax-nonce');
    }

    private function setupRouter(): void
    {
        $this->router = new Router();

        // Define pages and AJAX routes in separate methods for clarity
        $this->setupPages();
        $this->setupAjaxRoutes();
    }

    private function setupPages(): void
    {
        $pages = [
            [
                'slug' => 'my-ajax-plugin',
                'title' => 'My AJAX Plugin',
                'controller' => 'Wap\Page\Main',
                'scriptAsset' => true,
                'styleAsset' => false,
            ],
        ];

        foreach ($pages as $page) {
            $this->router->addRoute($page['slug'], $page['controller']);
            add_action('admin_enqueue_scripts', [new $page['controller'], 'enqueueAssets']);
            add_action('admin_menu', function () use ($page) {
                add_menu_page(
                    esc_html__($page['title'], 'wp-ajax-plugin'), // Page title
                    esc_html__($page['title'], 'wp-ajax-plugin'), // Menu title
                    'manage_options', // Capability
                    $page['slug'], // Menu slug
                    [$this->router, 'dispatch'], // Function
                    'dashicons-admin-generic' // Icon URL
                );
            });
        }
    }

    private function setupAjaxRoutes(): void
    {
        if (wp_doing_ajax()) {
            $ajaxRoutes = [
                [
                    'action' => 'my_action',
                    'controller' => 'Wap\Ajax\Main'
                ],
            ];

            foreach ($ajaxRoutes as $ajax) {
                $this->router->addAjaxRoute($ajax['action'], $ajax['controller']);
            }
        }
    }
}

new MyAjaxPlugin();