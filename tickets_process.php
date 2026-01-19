<?php
session_start();
require 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['cust_id'])) {
    die("Please log in to create a booking.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admission = trim($_POST['admission'] ?? '');
    $ticket_type = trim($_POST['ticket_type'] ?? '');
    $adult_ticket = trim($_POST['adult_ticket'] ?? '');
    $child_ticket = trim($_POST['child_ticket'] ?? '');


    // Use the logged-in user's session ID
    $cust_id = $_SESSION['cust_id'];

    // Validate required fields
    if ($admission === '' || $ticket_type === '' || $adult_ticket === '' || $child_ticket === '') { 
        die("⚠️ All fields are required. <a href='tickets.php'>Go back</a>");
    }

    $result = $conn->query("SELECT * FROM customer WHERE cust_id = $cust_id");
    if (!$result->fetch_assoc()) {
        die("⚠️ Customer not found.");
    }

    // Insert new booking
    $stmt = $conn->prepare("
        INSERT INTO tickets (cust_id, admission, ticket_type, adult_ticket, child_ticket) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issii", $cust_id, $admission, $ticket_type, $adult_ticket, $child_ticket);

    if ($stmt->execute()) {
        // Get the inserted booking ID
        $ticket_id = $conn->insert_id;

        // Redirect to the success page
        header("Location: tickets_success.php?id=$ticket_id");
        exit;
    } else {
        die("Booking failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
