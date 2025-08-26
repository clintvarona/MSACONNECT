<?php
require_once 'databaseClass.php';

class Account {

    public $last_name;
    public $first_name;
    public $middle_name; 
    public $username;
    public $email;
    public $password; 
    public $position;
    public $image;
    public $school_year;
    public $role;
    public $officer;

    protected $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);

        if ($query->execute()) {
            $data = $query->fetch();
            if ($data && password_verify($password, $data['password'])) {
                return true;
            }
        }

        return false;
    }

    function fetch($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }

    function fetchOfficerPositions() {
        $sql = "SELECT * FROM officer_positions ORDER BY position_id ASC";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        
        return $query->fetchAll();
    }    

    function signup() {
        $sql = "INSERT INTO users (first_name, last_name, middle_name, username, email, password, position_id) 
                VALUES (:first_name, :last_name, :middle_name, :username, :email, :password, :position)";
    
        $query = $this->db->connect()->prepare($sql);
    
        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':middle_name', $this->middle_name);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':email', $this->email);
        
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':position', $this->position); 
    
        $query->execute();
    }
    
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@wmsu\.edu\.ph$/', $email);
    }

    function validatePassword($password) {
        return strlen($password) >= 8;
    }

    function emailExist($email, $excludeID=null)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        if ($excludeID) {
            $sql .= " and id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':email', $email);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }

    function usernameExist($username, $excludeID=null)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        if ($excludeID) {
            $sql .= " and id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }
    
}

// $obj = new Account();
// $obj->signup();
?>