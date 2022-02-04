<?php 

namespace App\Tools;

class Log {

    public string $location;

    private string $method         = '';
    private string $message        = '';
    private string $status         = '';
    private string $fail_reason    = '';
    private string $remote_address = '';
    private string $remote_port    = '';

    public function __construct(string $location) {
        $file_location = "{$_ENV['APP_ROOT']}views/logs/{$location}.log"; 

        // Add to location variable if exists
        if(file_exists($file_location)) {
            $this->location = $file_location;

            return $this;
        }

        // Create log file if not exists and add to location variable 
        $fh = fopen($file_location, "w");
        $this->location = $file_location;
        fclose($fh);
            
        return true;
    }

    public function method(string $method) {
        $this->method = $method;

        return $this;
    }

    public function message(string $text) {

        $this->message .= empty($this->message) ? $text : ', ' . $text;

        return $this;
    }

    public function status(string $status) {
        $this->status = $status;

        return $this;
    }

    public function remote($address = false, $port = false) {
        if($address) {
            $this->remote_address = $_SERVER['REMOTE_ADDR'];
        }
        if($port) {
            $this->remote_port = $_SERVER['REMOTE_PORT'];
        }

        return $this;
    }

    public function reason(string $text) {
        $this->fail_reason .= empty($this->fail_reason) ? $text : ', ' . $text;

        return $this;
    }

    public function write() {
        $this->remote(true, true);
        
        // Generate log file message
        $date     = new \DateTime;
        $message  = "\n";
        $message .= strtoupper($this->method) ."\t";
        $message .= strtoupper($this->status) . "\t";
        $message .= !empty($this->fail_reason)    ? $this->fail_reason . "\t" : '';
        $message .= !empty($this->message)        ? $this->message ."\t" : '';
        $message .= !empty($this->remote_address) ? "{$this->remote_address}\t" : '';
        $message .= !empty($this->remote_port)    ? $this->remote_port . "\t" : '';
        $message .= $date->format('Y-F-j') . "\t";
        $message .= $date->format('H:i:s') . "\t";
        $message .= "\n";

        // Check if is writable and append to file
        if(is_writable($this->location)) {

            $fh = fopen($this->location, "a");

            fwrite($fh, $message);
            fclose($fh);

            return true;

        }

        die("Unable to write to file");
    }

}