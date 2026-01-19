<?php

session_start();
require 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

  
    $stmt = $conn->prepare("SELECT cust_id, name, password FROM customer WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($cust_id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['cust_id']   = $cust_id;
            $_SESSION['name'] = $name;
            header("Location: account.php");
            exit;
        } else {
            die("Incorrect password. <a href='account.php'>Go back</a>");
        }
    }



    $stmt->close();
    $conn->close();
}
?>
