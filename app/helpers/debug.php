<?php 

function print_to_screen($param) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

function error_handler(int $err_no, string $err_msg, string $file, int $line) {

    $errors = array(
        E_ERROR           => 'ERROR',
        E_PARSE           => 'PARSE ERROR',
        E_WARNING         => 'WARNING',
        E_NOTICE          => 'NOTICE',
        E_STRICT          => 'RUNTIME ERROR',
        E_CORE_ERROR      => 'CORE ERROR',
        E_CORE_WARNING    => 'CORE WARNING',
        E_COMPILE_ERROR   => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_ERROR      => 'USER ERROR',
        E_USER_WARNING    => 'USER WARNING',
        E_USER_NOTICE     => 'USER NOTICE',
        E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR'
    );

    $date = new \DateTime;
    $error_type = array_key_exists($err_no, $errors) ? $errors[$err_no] : "System Error";

    $message  = $error_type . "\t\t";
    $message .= $date->format('Y-F-j') . "\t";
    $message .= $date->format('H:i:s') . "\t";
    $message .= $err_msg . "\t";
    $message .= $file . "\t";
    $message .= $line . "\t";
    $message .= "\n\n";

    $destination = $_ENV['APP_ROOT'] . "views/logs/errors/error.log";



    if(!file_exists($destination)) {
        redirect("500");
    }
    else if(!is_writable($destination)) {
        redirect("500");
    }
    else {
        error_log($message, 3, $destination);
    }
}