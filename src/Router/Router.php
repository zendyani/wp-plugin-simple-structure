<?php

namespace Wap\Router;

class Router {
    protected array $routes = [];
    protected array $ajaxRoutes = [];
    
    public function addRoute(string $slug, string $controller): void {
        $this->routes[$slug] = $controller;
    }

    public function addAjaxRoute(string $action, string $controller): void {
        $this->ajaxRoutes[$action] = $controller;
        add_action("wp_ajax_{$action}", [$this, 'dispatchAjax']);
        // Optionally, handle nopriv actions too:
        // add_action("wp_ajax_nopriv_{$action}", [$this, 'dispatchAjax']);
    }

    public function dispatch(): void {
        $page = $_GET['page'] ?? '';
        $page = sanitize_text_field($page); // Sanitize the input
        if (array_key_exists($page, $this->routes)) {
            $controller = $this->instantiateController($this->routes[$page]);
            $controller->handler();
        } else {
            // Handle error or redirect
            wp_die('Page not found', 404);
        }
    }

    public function dispatchAjax(): void {
        $action = $_POST['action'] ?? '';
        $action = sanitize_text_field($action); // Sanitize the input
        if (array_key_exists($action, $this->ajaxRoutes)) {
            // Verify nonce if implemented
            $controller = $this->instantiateController($this->ajaxRoutes[$action]);
            $controller->handler();
        } else {
            // Handle error or redirect
            wp_die('Action not found', 404);
        }
    }

    protected function instantiateController(string $controllerClass) {
        if (class_exists($controllerClass)) {
            return new $controllerClass();
        } else {
            // Handle error
            wp_die('Controller class not found', 404);
        }
    }
}
