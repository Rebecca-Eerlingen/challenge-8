<?php

session_start();
require_once "config.php";

if (isset($_POST['register'])) {
    $_SESSION['active_form'] = "register";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users_tb WHERE email = '$email'");
    var_dump($checkEmail);
    if ($checkEmail->num_rows > 0) {
       $_SESSION['register_error'] = "email already exists";
    } else {
        $conn->query("INSERT INTO users_tb (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }

    header("Location: login.php");
    exit();
}   


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users_tb WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

        } else {
            $_SESSION['login_error'] = "Incorrect email or password";
            $_SESSION['active_form'] = 'login';

            header("Location: login.php");
        }
        
        if ($user['role'] === 'admin') {
            header("Location: admin_page.php");
        } else {
            header("Location: user_page.php");
        }
        exit();
    } 
}

$_SESSION['login_error'] = "incorrect email or password";
$_SESSION['active_form'] = 'login';
header("Location: login.php");
exit();

?>