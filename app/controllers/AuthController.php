<?php

require_once "../core/Controller.php";
require_once "../core/Session.php";
require_once "../middleware/Middleware.php";

class AuthController extends Controller{
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        Session::Start();
    }

        // Show login page
    public function loginPage() {
        $this->view("auth/login");
    }

    // Show registration page
    public function registerPage() {
        $this->view('auth/register');
    }


    // Handle login request

    public function login() {

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);

        if (empty($username)) {
            $errors['username'] = "Username is required.";
        }

        if (empty($password)) {
            $errors['password'] = "Password is required.";
        }

        // Only proceed with authentication if no validation errors
        if (empty($errors)) {
            $user = $this->userModel->login($username, $password);

            if ($user) {
                Session::start();
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);

                $rolesRaw = $this->userModel->getRoles($user['id']);
                $roles = array_column($rolesRaw, 'name');
                Session::set('roles', $roles);
                
                Middleware::redirectIfLoggedIn();
                return; // return here to prevent showing the view
             
            } else {
               $errors['credentials'] = 'Invalid username or password';
            }
        }

        $this->view('auth/login', ['errors' => $errors]);

    } else {
        $this->view('auth/login');
    }
}


    // Handle register request
 public function register() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars(trim($_POST['username']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm-password']);

        $errors = [];

        // Validate username
        if (empty($username)) {
            $errors['username'] = "Username is required";
        } elseif (strlen($username) < 3) {
            $errors['username'] = "Username must be at least 3 characters";
        }

        // Validate email
        if (empty($email)) {
            $errors['email'] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email address";
        } elseif ($this->userModel->emailExists($email)) {
            $errors['email'] = "This email is already in use";
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($password) < 8) {
            $errors['password'] = "Password must be at least 8 characters long";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $errors['password'] = "Password must contain at least one uppercase letter";
        } elseif (!preg_match("/[a-z]/", $password)) {
            $errors['password'] = "Password must contain at least one lowercase letter";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $errors['password'] = "Password must contain at least one number";
        } elseif (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
            $errors['password'] = "Password must contain at least one special character";
        }

        // Confirm password
        if (empty($confirmPassword)) {
            $errors['confirm_password'] = "Confirm Password is required.";
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Passwords do not match.";
        }

        if (empty($errors)) {
            try {
                if ($this->userModel->register($username, $email, $password)) {
                    $userId = $this->userModel->getLastInsertedId();
                    
                    $this->userModel->assignRole($userId, 'admin');
                
                    header('Location: ' . BASE_URL . '/auth/login');
                    exit;
                } else {
                    $errors['registration'] = "Registration failed. Please try again.";
                }
            } catch (Exception $e) {
                // Log the error for debugging
                error_log("Registration error: " . $e->getMessage());
                $errors['registration'] = "Registration failed. Please try again.";
            }
        }
        
        $this->view('auth/register', ['errors' => $errors]);

    } else {
        $this->view('auth/register');
    }
}


    // Logout user
    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . '/user/index');
        exit;
    }
}
