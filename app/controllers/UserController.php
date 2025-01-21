<?php

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class UserController extends Controller{

    public function index(){
        $this->view('index');
    }

    public function admin(){
        Session::start();
        $username = Session::get('username');
        $this->view('admin/dashboard', ['username' => $username]);
    }

    public function home(){
        Session::start();
        $username = Session::get('username');
        $this->view('user/home', ['username' => $username]);

    }

}