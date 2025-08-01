<?php

class User {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../lib/Database.php';
        $this->db = new Database();
    }

    /**
     * Find user by username
     */
    public function findByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    /**
     * Register a new user
     * @param array $data Contains username and password
     */
    public function register($data) {
        $this->db->query("INSERT INTO users (username, password) VALUES (:username, :password)");

        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Login user
     * @param string $username
     * @param string $password
     * @return mixed The user object on success, false on failure
     */
    public function login($username, $password) {
        $row = $this->findByUsername($username);

        if ($row) {
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                return $row; // Return user data
            }
        }

        return false; // Login failed
    }
}
?>
