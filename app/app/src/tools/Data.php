<?php 

namespace App\Tools;

use App\Utilities\ClassNameInterface;

class Data implements ClassNameInterface {

    public array  $countries  = [];

    public string $class_name = "";
    public string $title      = "";

    public function __construct() {
        $this->generate_class_name();
    }

    public function generate_class_name() {
        if(!property_exists($this, "class_name")) {
            trigger_error('Required property "class_name" does not exists');
            return;
        }

        $this->class_name = __CLASS__;

        $class_array = explode("\\", $this->class_name);
        $this->class_name = strtolower(end($class_array));
    }

}