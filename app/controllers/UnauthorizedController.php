<?php 

require_once "../core/Controller.php";
require_once "../core/Session.php";


class UnauthorizedController extends Controller {
    public function index() {
        $this->view('unauthorized');
    }
}