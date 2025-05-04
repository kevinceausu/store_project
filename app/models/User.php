<?php

require_once __DIR__ . '/../core/Database.php';

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUser($username, $email, $password_hash)
{
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash) 
                                VALUES (:username, :email, :password_hash)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password_hash);
    return $stmt->execute();
}


    public function getUserByEmail($email)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
