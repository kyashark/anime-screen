<?php

require_once '../core/Session.php';

class Middleware{

    public static function requireLogin() {
    Session::start();
    if (!Session::get('user_id')) {
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}


    // Check if user has a single role
    public static function hasRole($role) {
        return in_array($role, $_SESSION['roles'] ?? []);
    }

    // Check if user has any of the given roles
    public static function hasAnyRole(array $roles) {
        return count(array_intersect($roles, $_SESSION['roles'] ?? [])) > 0;
    }

    // Require a specific role or redirect
    public static function requireRole($role) {
        Session::start();
        if (!Session::hasRole($role)) {
            header("Location: " . BASE_URL . "/unauthorized");
            exit;
        }
    }

    // Require any of the roles or redirect
    public static function requireAnyRole(array $roles) {
        Session::start();
        if (!Session::hasAnyRole($roles)) {
            header("Location: " . BASE_URL . "/unauthorized");
            exit;
        }
    }

    public static function redirectIfLoggedIn() {
    Session::start();

    if (Session::get('user_id')) {
        $roles = Session::get('roles') ?? [];

        if (in_array('admin', $roles)) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        } elseif (in_array('editor', $roles)) {
            header('Location: ' . BASE_URL . '/user/home');
            exit;
        } elseif (in_array('user', $roles)) {
            header('Location: ' . BASE_URL . '/user/home');
            exit;
        } else {
            Session::destroy();
            header('Location: ' . BASE_URL . '/unauthorized');
            exit;
        }
    }
}

}