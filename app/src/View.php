<?php 

namespace App;

class View {
    
    private array   $content   = [];
    private string  $page      = '';
    private string  $layout    = '';

    public function __construct(string $page, string $layout = 'main') {
        $this->page   = $_ENV['APP_ROOT'] . 'views/' .$page . '.php';
        $this->layout = $_ENV['APP_ROOT'] . 'views/layouts/' . $layout . '.layout.php';

        if(!file_exists($this->page)) {
            trigger_error('View Error: Unable to location file ' . $this->page);
            exit;
        }
        elseif(!file_exists($this->layout)) {
            trigger_error('View Error: Unable to location layout file ' . $this->layout);
            exit;
        }
    }

    public function import(array $datas) {
        foreach($datas as $data) {
            $key = $data->class_name;
            $this->content[$key] = $data;
        } 

        return $this;
    }

    public function display() {
        foreach($this->content as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include $this->page;

        $content = ob_get_clean();

        include $this->layout;
    }
}