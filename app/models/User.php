<?php

class User{
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    // Register a new user
    public function register($username,$email,$password){
        
        $passwordHash = password_hash($password,PASSWORD_BCRYPT);

        $is_admin = 0;

        $stmt = $this->db->prepare("INSERT INTO users(username,email,password,is_admin) VALUES (?,?,?,?)");
        return $stmt->execute([$username,$email,$passwordHash,$is_admin]);
    }

    // User login
    public function login($username,$password){

    $stmt = $this->db->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if($user && password_verify($password,$user['password'])){
        return $user;
    }
    return false;
    }


    // chech if email already exits
    public function emailExists($email){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}