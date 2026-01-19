<?php
session_start();
require 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['cust_id'])) {
    die("Please log in to create a booking.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkin = trim($_POST['checkin'] ?? '');
    $checkout = trim($_POST['checkout'] ?? '');
    $room_type = trim($_POST['room_type'] ?? '');
    $adult_guest = trim($_POST['adult_guest'] ?? '');
    $child_guest = trim($_POST['child_guest'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    // Use the logged-in user's session ID
    $cust_id = $_SESSION['cust_id'];

    // Validate required fields
    if ($checkin === '' || $checkout === '' || $room_type === '' || $adult_guest === '' || $child_guest === '') { 
        die("⚠️ All fields are required. <a href='bookings.php'>Go back</a>");
    }

    if ($checkout <= $checkin) {
        die("⚠️ Checkout date must be after check-in date. <a href='bookings.php'>Go back</a>");
    }

    $result = $conn->query("SELECT * FROM customer WHERE cust_id = $cust_id");
    if (!$result->fetch_assoc()) {
        die("⚠️ Customer not found.");
    }

    // Insert new booking
    $stmt = $conn->prepare("
        INSERT INTO bookings (cust_id, checkin, checkout, room_type, adult_guest, child_guest, notes) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssiis", $cust_id, $checkin, $checkout, $room_type, $adult_guest, $child_guest, $notes);

    if ($stmt->execute()) {
        // Get the inserted booking ID
        $booking_id = $conn->insert_id;

        // Redirect to the success page
        header("Location: hotel_success.php?id=$booking_id");
        exit;
    } else {
        die("Booking failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
