<?php
require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class AdminController extends Controller {
    
public function dashboard() {
    Middleware::requireLogin();

    if (!Middleware::hasRole('admin')) {
        header('Location: ' . BASE_URL . '/unauthorized');
        exit;
    }

    $username = Session::get('username');
        $this->view('admin/dashboard', ['username' => $username]);
}
}