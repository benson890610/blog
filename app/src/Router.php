<?php 

namespace App;

class Router {

    private array $get_routes  = [];
    private array $post_routes = [];
    private array $home_routes = ['/', '/index', '/home'];

    private object $controller;
    private string $method;
    private array  $params = [];

    public static string $method_name = '';

    // GET ROUTES
    public function get(string $route, array $params) : void {
        $this->get_routes[$route] = $params;
    }

    // POST ROUTES
    public function post(string $route, array $params) : void {
        $this->post_routes[$route] = $params;
    }
    
    // MAIN ROUTE METHOD
    public function load() : void {
        $route = $this->get_url();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->resolve_post($route);
        } else {
            $this->resolve_get($route);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // GET ROUTE
    private function get_url() : string {
        $url = $_SERVER['REQUEST_URI'];

        /* For production site code
           $url = str_replace('/projects/blog', '', $url);
        */

        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = ($url === '/') ? $url : rtrim($url, '/');

        return $url;
    }

    // RESOLVE GET
    private function resolve_get(string $route) : void {
        if(in_array($route, $this->home_routes)) {
            $this->load_home_page();
        } else {
            $route_array = explode('/', ltrim($route, '/'));

            if(count($route_array) > 1) {
                $this->resolve_select_box($route_array);

                $controller = $route_array[0];
                $method     = $route_array[1];

                unset($route_array[0]);
                unset($route_array[1]);

                $this->params = array_values($route_array);

                $new_route = "/" . $controller . "/" . $method;
                
                if(array_key_exists($new_route, $this->get_routes)) {
                    $this->load_custom_page($new_route);
                    return;
                }

            } else {
                $new_route = "/" . $route_array[0];

                if(array_key_exists($new_route, $this->get_routes)) {
                    $this->load_custom_page($new_route);
                    return;
                }
            }

            $this->load_error_page('404');
        }
    }

    // RESOLVE POST
    private function resolve_post(string $route) : void {
        if(in_array($route, $this->home_routes)) {
            $this->load_home_page();
        } else {
            $route_array = explode('/', ltrim($route, '/'));

            if(count($route_array) > 1) {
                $controller = $route_array[0];
                $method     = $route_array[1];

                unset($route_array[0]);
                unset($route_array[1]);

                $this->params = array_values($route_array);

                $new_route = "/" . $controller . "/" . $method;

                if(array_key_exists($new_route, $this->post_routes)) {
                    $this->load_custom_page($new_route);
                    return;
                }

            } else {
                $new_route = "/" . $route_array[0];

                if(array_key_exists($new_route, $this->post_routes)) {
                    $this->load_custom_page($new_route);
                    return;
                }
            }

            $this->load_error_page('404');
        }
    }

    private function resolve_select_box(&$arr) : void {
        if(stristr($arr[1], "?")) {

            $tmp_arr = explode("?", $arr[1]);
            $arr[1] = $tmp_arr[0];

            if(isset($tmp_arr[1])) {

                $query_string = $tmp_arr[1];

                if(stristr($query_string, "=")) {
                    $query_string_arr = explode("=", $query_string);
                    if(isset($query_string_arr[1])) array_push($arr, $query_string_arr[1]);
                }
            }

        }
    }

    // LOAD HOME 
    private function load_home_page() : void {
        $resolve = ($_SERVER['REQUEST_METHOD'] === 'GET') ? $this->get_routes['/'] : $this->post_routes['/'];

        $this->controller = new $resolve['class'];
        $this->method     = $resolve['method'];
    }

    // LOAD ERROR
    private function load_error_page(string $error) : void {
        $resolve = $this->get_routes['/' . $error];

        $this->controller = new $resolve['class'];
        $this->method     = $resolve['method'];
    }

    // LOAD CUSTOM
    private function load_custom_page(string $route) : void {
        $resolve = ($_SERVER['REQUEST_METHOD'] === 'GET') ? $this->get_routes[$route] : $this->post_routes[$route];

        $this->controller = new $resolve['class'];
        $this->method     = $resolve['method'];
    }

}