<?php

namespace PtrSoc\Interfaces\WordPress\Ajax;

class AjaxRouter
{
    public function __construct(private array $routes)
    {
        $this->routes = $routes;
    }

    public function register()
    {
        foreach ($this->routes as $route) {

            $action = $route->action();

            $wrapped = function () use ($route, $action) {
                if (!function_exists('wp_doing_ajax') || !wp_doing_ajax()) {
                    wp_send_json_error(['message' => 'Invalid context'], 400);
                }

                check_ajax_referer($route->nonceAction(), 'ptrsoc_nonce');

                try {
                    call_user_func($route->callback());
                } catch (\Throwable $e) {
                    error_log(print_r($e, true));
                    wp_send_json_error(['message' => 'Server error'], 500);
                }
                die();
            };

            add_action("wp_ajax_{$action}", $wrapped);
        }
    }
}
