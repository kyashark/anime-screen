<?php
require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class AdminController extends Controller {
    public function index(){
        $this->view('index');
    }
    public function dashboard() {
        Session::start();
        $username = Session::get('username');
        $is_admin = (int) Session::get('is_admin');

        // Only allow access if the user is an admin
        if (!$is_admin) {
            echo "Access Denied!";
            exit;
        }

        $this->view('admin/dashboard', [
            'username' => $username,
            'is_admin' => $is_admin
        ]);
    }

    public function movieManagement() {
        Session::start();
        $username = Session::get('username');
        $is_admin = (int) Session::get('is_admin');

        if (!$is_admin) {
            echo "Access Denied!";
            exit;
        }

        $this->view('admin/movieManagement', ['username' => $username]);
    }

    public function userManagement() {
        Session::start();
        $username = Session::get('username');
        $is_admin = (int) Session::get('is_admin');

        if (!$is_admin) {
            echo "Access Denied!";
            exit;
        }

        $this->view('admin/userManagement', ['username' => $username]);
    }
}