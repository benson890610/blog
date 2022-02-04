<?php

function is_valid_ajax_request(string $referer_page) : bool {

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === $_ENV['APP_SRC'] . $referer_page) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return true;
        }
    }

    return false;

}

function is_basic_ajax_request() : bool {
    if(isset($_SERVER['HTTP_REFERER'])) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') return true;

        return false;
    }

    return false;
}

function is_whole_positive_integer($num) {
    if(is_numeric($num) && $num > 0) {
        $result = $num / (int)$num;

        if(is_float($result)) return false;

        return true;
    }

    die("WRONG");



    return false;
}