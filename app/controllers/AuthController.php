<?php

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class authController extends Controller{
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        Session::Start();
    }


    // Handle login request
    public function login(){ 

        $errors = [
            'username' => '',
            'password' => '',
            'credentials' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username']));
            $password = trim($_POST['password']);

            // Validate username
            if(empty($username)){
                $errors['username'] = "Username is required.";
             }

            // Validate password
            if(empty($password)){
                $errors['password'] = "Password is required.";
            }

            if(empty(array_filter($errors, fn($value) => !empty($value)))){

                // Attempt login
                $user = $this->userModel->login($username, $password);

                if($user){
                    // Successful login
                    Session::set('user_id', $user['id']);
                    Session::set('username', $user['username']);
                    Session::set('is_admin', $user['is_admin']);
                
                    Middleware::redirectIfLoggedIn();
                }else{
                    $errors['credentials'] = 'Invalid username or password';
                }
            }
        }
        $this->view('auth/login', ['errors' => $errors]);
    }


    // Handle register request
    public function register(){

        $errors = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm-password' => '',
            'registration' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = htmlspecialchars(trim($_POST['username']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm-password']);

            // Validate username
            if(empty($username)){
                $errors['username'] = "Username is required.";
            }elseif(strlen($username)< 4){
                $errors['username'] = "Username must be at least 4 characters.";
            }

            // Validate Email
            if (empty($email)) {
                $errors['email'] = "Email is required";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email address.";
            } elseif ($this->userModel->emailExists($email)) {
                $errors['email'] = "This email is already in use.";
            }

            // Validate password
            if (empty($password)) {
                $errors['password'] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Password must be at least 6 characters long.";
            } elseif (!preg_match("/[A-Z]/", $password)) {
                $errors['password'] = "Password must contain at least one uppercase letter.";
            } elseif (!preg_match("/[0-9]/", $password)) {
                $errors['password'] = "Password must contain at least one number.";
            }

            // Check confirm password
            if (empty($confirmPassword)) {
                $errors['confirm-password'] = "Confirm Password is required.";
            } elseif ($password !== $confirmPassword) {
                $errors['confirm-password'] = "Passwords do not match.";
            }

            if(empty(array_filter($errors, fn($value) => !empty($value)))){
                if($this->userModel->register($username,$email,$password)){
                    header('Location: ' . BASE_URL . '/auth/login');
                    exit;
                }else{
                    $errors['registration'] = "Registration failed. Please try again.";
                }
            }
        }
        $this->view('auth/register', ['errors' => $errors]);
    }


    // Logout user
    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/user/index');
        exit;
    }
}
