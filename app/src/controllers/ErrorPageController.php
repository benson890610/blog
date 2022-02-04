<?php 

namespace App\Controllers;

use App\Controller;

class ErrorPageController extends Controller {

    public function page_not_found() {

        $this->view('errors/pageNotFound')->display();

    }

    public function access_forbidden() {

        $this->view('errors/accessForbidden')->display();

    }

    public function server_error() {

        $this->view('errors/serverError')->display();

    }

}