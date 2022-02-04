<?php 

namespace App\Utilities;

interface ControllerInterface {
    public function model(string $name);
    public function view(string $page, string $layout);
}