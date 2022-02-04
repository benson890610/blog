<?php 

namespace App;

use App\Utilities\ControllerInterface;
use App\Tools\Log;
use App\Tools\Mailer;

class Controller implements ControllerInterface {

    public function model(string $name) {
        if(file_exists($_ENV['APP_ROOT'] . 'src/models/' . $name . '.php')) {
            $model = "App\Models\\$name";
            return new $model;
        }

        trigger_error('Base Controller Error: Unable to locate ' . $name . ' model');
    }

    public function view(string $page, string $layout = 'main') {
        if(file_exists($_ENV['APP_ROOT'] . 'src/View.php')) {
            return new View($page, $layout);
        }

        trigger_error('Base Controller Error: Unable to locate main View class file');
        exit;
    }

    public function logs(string $file_location) {
        if(file_exists($_ENV['APP_ROOT'] . 'src/tools/Log.php')) {
            return new Tools\Log($file_location);
        }

        $message = "Log Error: Unable to locate Log class";
        trigger_error($message);

        return false;
    }

    public function mailer() {

        if(file_exists($_ENV['APP_ROOT'] . 'src/tools/Mailer.php')) {

            $mailer = new Mailer;

            return $mailer;

        }

    }
    
}