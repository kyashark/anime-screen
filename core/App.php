<?php

class App{

    public function __construct(){
        $url = $this->parseUrl();
        $controllerName = $url[0]. 'Controller';
        $method = $url[1] ?? null;

        require_once "../app/controllers/$controllerName.php";
        $controller = new $controllerName;


        if ($method && method_exists($controller, $method)) {
            // If method exists in controller, call it
            call_user_func_array([$controller, $method], array_slice($url, 2));
        } else {
            // If no method or constructor is used, do nothing
            // This will call the constructor automatically if there's no specific method
        }
    }

    private function parseUrl(){
        if(isset($_GET['url'])){
            return explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
        }
        return ['user','index']; // Default route
    }
}