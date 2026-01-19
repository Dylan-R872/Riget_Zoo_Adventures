<?php
/*
 * User Registration Script
 */

session_start();
require 'db_connect.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
 
    if (empty($name) || empty($email) || empty($password) || empty($phone)) {
        die("⚠️ All fields are required. <a href='account.php'>Go back</a>");
    }
 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    // Check if email exists
    $stmt = $conn->prepare("SELECT cust_id FROM customer WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows > 0) {
        $stmt->close();
        die("⚠️ Email already registered. <a href='account.php'>Go back</a>");
    }
    $stmt->close();
 
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO customer (name, email, password, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $phone);
 
    if ($stmt->execute()) {
        $_SESSION['cust_id'] = $stmt->insert_id;
        $_SESSION['name'] = $name;
        header("Location: account.php");
        exit;
    } else {
        die("Registration failed: " . $stmt->error);
    }
 
    $stmt->close();
    $conn->close();
}
 
?>
