<?php 

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Register a new user
    public function register($username, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $passwordHash]);
    }

    // Get last inserted user ID
    public function getLastInsertedId() {
        return $this->db->lastInsertId();
    }

    // Assign a role to user
    public function assignRole($userId, $roleName) {
       
        // Get the role ID from the roles table
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = :name");
        $stmt->execute([':name' => $roleName]);
        $role = $stmt->fetch();

        if ($role) {
            // Insert into user_roles table
            $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
            return $stmt->execute([
                ':user_id' => $userId,
                ':role_id' => $role['id']
            ]);
        }

        return false;
    }


    // User login
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Get user roles as array
    public function getRoles($userId) {
        $query = "SELECT r.name FROM roles r 
                INNER JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Check if email already exists
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }
}
