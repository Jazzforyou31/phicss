<?php
require_once 'databaseClass.php';

class AccountClass {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect(); // Correctly initialize $this->db
    }

    public function getAllUsers() {
        try {
            $query = "
                SELECT 
                    user_id, 
                    username, 
                    first_name, 
                    middle_name, 
                    last_name, 
                    email, 
                    role, 
                    datetime_sign_up, 
                    datetime_last_online 
                FROM 
                    account
                ORDER BY 
                    datetime_sign_up DESC
            ";

            $statement = $this->db->prepare($query); // Use $this->db instead of $this->db->conn
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error fetching users: " . $exception->getMessage();
            return [];
        }
    }

    public function registerAccount($username, $password, $firstName, $middleName, $lastName, $email, $role) {
        try {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Get current timestamp for sign-up date
            $currentDateTime = date('Y-m-d H:i:s');
            
            // Insert the new user into the database
            $query = "INSERT INTO account (username, password, first_name, middle_name, last_name, email, role, datetime_sign_up, datetime_last_online) 
                    VALUES (:username, :password, :first_name, :middle_name, :last_name, :email, :role, :datetime_sign_up, :datetime_last_online)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':datetime_sign_up', $currentDateTime);
            $stmt->bindParam(':datetime_last_online', $currentDateTime);
            
            return $stmt->execute(); // Returns true if the query is successful, false if not
        } catch (PDOException $e) {
            // Log the error
            error_log("Error registering account: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId) {
        try {
            $query = "
                SELECT 
                    user_id, 
                    username, 
                    first_name, 
                    middle_name, 
                    last_name, 
                    email, 
                    role
                FROM 
                    account
                WHERE 
                    user_id = :user_id
            ";

            $statement = $this->db->prepare($query);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error fetching user by ID: " . $exception->getMessage());
            return false;
        }
    }

    public function updateUser($userId, $username, $firstName, $middleName, $lastName, $email, $role) {
        try {
            // Update user information
            $query = "
                UPDATE account 
                SET 
                    username = :username,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    email = :email,
                    role = :role
                WHERE 
                    user_id = :user_id
            ";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function updatePassword($userId, $newPassword) {
        try {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update the password
            $query = "UPDATE account SET password = :password WHERE user_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':password', $hashedPassword);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($userId) {
        try {
            $query = "DELETE FROM account WHERE user_id = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function searchUsers($searchTerm = '', $role = '') {
        try {
            // Base query
            $query = "
                SELECT 
                    user_id, 
                    username, 
                    first_name, 
                    middle_name, 
                    last_name, 
                    email, 
                    role, 
                    datetime_sign_up, 
                    datetime_last_online 
                FROM 
                    account
                WHERE 1=1
            ";
            
            $params = [];
            
            // Add search term condition if provided
            if (!empty($searchTerm)) {
                $query .= " AND (
                    username LIKE :searchTerm OR 
                    first_name LIKE :searchTerm OR 
                    last_name LIKE :searchTerm OR 
                    email LIKE :searchTerm
                )";
                $searchParam = "%{$searchTerm}%";
                $params[':searchTerm'] = $searchParam;
            }
            
            // Add role filter if provided
            if (!empty($role)) {
                $query .= " AND role = :role";
                $params[':role'] = $role;
            }
            
            // Add order by
            $query .= " ORDER BY datetime_sign_up DESC";
            
            $statement = $this->db->prepare($query);
            
            // Bind parameters
            foreach ($params as $param => $value) {
                $statement->bindValue($param, $value);
            }
            
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Error searching users: " . $exception->getMessage());
            return [];
        }
    }
}
    
