<?php 

function redirect(string $location) {
    header("Location: " . $_ENV['APP_SRC'] . $location);
    exit;
}

function redirect_referer() {
    $referer = $_SERVER['HTTP_REFERER'] ?? $_ENV['APP_SRC'];
    
    header("Location: " . $referer);
    exit;
}

function link_url(string $page = '') {
    if(isset($_ENV['APP_SRC'])) return $_ENV['APP_SRC'] . $page;
    
    return '';
}

function link_image(string $basename, string $extension) {
    if(isset($_ENV['APP_SRC'])) {
        $image = $_ENV['APP_SRC'] . "public/images/{$basename}.$extension";
        return $image;
    }

    return '';
}

function js_url(string $page = '') {
    if(isset($_ENV['APP_SRC'])) return $_ENV['APP_SRC'] . 'public/' . $page . '.js';

    return '';
}

function get_route_method() {

    if(isset($_GET['route'])) {
        $route_arr  = explode('/', rtrim($_GET['route'], '/'));

        if(count($route_arr) > 0) {
            $method = isset($route[1]) ? $route[1] : '';

            return $method;
        }

        return '';
    }

    return '';
}