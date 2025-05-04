<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login()
{
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['Active'] = true;
            $_SESSION['Username'] = $user['username'];
            $_SESSION['UserID'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: index.php");
            exit;
        } else {
            $message = "❌ Invalid email or password.";
        }
    }

    require __DIR__ . '/../views/auth/login.php';
}

public function register()
{
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!empty($username) && !empty($email) && !empty($password)) {
            if ($this->userModel->getUserByEmail($email)) {
                $message = "❌ Email is already registered.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                if ($this->userModel->createUser($username, $email, $password_hash)) {
                    $message = "✅ Registered successfully. <a href='router.php?controller=auth&action=login'>Click here to log in</a>.";
                } else {
                    $message = "❌ Registration failed.";
                }
            }
        } else {
            $message = "❌ All fields are required.";
        }
    }

    require __DIR__ . '/../views/auth/register.php';
}

}
