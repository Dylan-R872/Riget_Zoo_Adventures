<?php

// Start session and check login state
session_start();
require 'db_connect.php';

$isLoggedIn = isset($_SESSION['cust_id']);
$Name   = $isLoggedIn ? htmlspecialchars($_SESSION['name']) : '';

$booking_id = $_GET['id'] ?? null;

if (!$booking_id) {
    die("Booking ID missing.");
}

if (!$isLoggedIn) {
    header("Location: account.php");
    exit;
}



// Get booking details
$stmt = $conn->prepare("
    SELECT b.*, c.name AS customer_name 
    FROM bookings b
    JOIN customer c ON b.cust_id = c.cust_id
    WHERE b.booking_id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found.");
}

if ($booking['cust_id'] != $_SESSION['cust_id']) {
    die("You are not authorized to view this booking.");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>RZA | Booking Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="images/favicon.png" type="image/png">
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body>

  <!-- HEADER / NAVIGATION -->
  <header class="site-header">
    <nav class="navbar">
      <div class="logo">🦁 Riget Zoo Adventures</div>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="account.php">Account</a></li>
        <li><a href="index.html#about-us">About Us</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
      <input type="text" id="searchInput" placeholder="Search...">
      
      <div class="sideMenu" id="sideMenu">
        <a href="javascript:void(0)"
            class="closeBtn"
            onclick="closeNav()">
            x
        </a>
        <div class="mainMenu">
            <h2>Menu</h2>
            <a href="index.html" 
            onclick="showContent('Home')">Home</a>
            <a href="visit.html" 
            onclick="showContent('Plan')">Plan Your Visit</a>
            <a href="tickets.php"  
            onclick="showContent('Tickets')">Ticket Admission</a>
            <a href="safari.html"
            onclick="showContent('Safari')">Animals & Safari</a>
            <a href="hotel.php"  
            onclick="showContent('Hotel')">Hotel Bookings</a>
            <a href="education.html"  
            onclick="showContent('Education')">Education</a>
            <a href="javascript:void(0)" 
            onclick="showContent('Membership')">Membership & Loyalty</a>
            <a href="account.php" 
            onclick="showContent('Account')">Account</a>
            <a href="contact.html" 
            onclick="showContent('Contact')">Contact</a>
            <a href="legal.html" 
            onclick="showContent('Legal')">Legal & Policies</a>
        </div>
      </div>
      <div class="contentArea">
        <span class="open-icon" onclick="openNav()">≡</span>
      </div>
    
    </nav>
  </header>

  <!-- SUCCESSFUL BOOKING  -->
  <section class="account-section">
    <div class="account-box active" id="login-box">
      <h2>Booking Confirmation</h2>
      <p>Thank you, <strong><?= htmlspecialchars($booking['customer_name']) ?></strong>!</p>
      <p>Your booking has been successfully recorded.</p>
      <br>

      <h2>Booking Details</h2>
      <table class="receipt-table">
          <tr>
              <th>Booking ID</th>
              <td><?= $booking['booking_id'] ?></td>
          </tr>
          <tr>
              <th>Customer</th>
              <td><?= htmlspecialchars($booking['customer_name']) ?></td>
          </tr>
          <tr>
              <th>Check-in</th>
              <td><?= $booking['checkin'] ?></td>
          </tr>
          <tr>
              <th>Check-out</th>
              <td><?= $booking['checkout'] ?></td>
          </tr>
          <tr>
              <th>Room Type</th>
              <td><?= htmlspecialchars($booking['room_type']) ?></td>
          </tr>
          <tr>
              <th>Adult Guests</th>
              <td><?= $booking['adult_guest'] ?></td>
          </tr>
          <tr>
              <th>Child Guests</th>
              <td><?= $booking['child_guest'] ?></td>
          </tr>
          <?php if (!empty($booking['notes'])): ?>
          <tr>
              <th>Special Requests</th>
              <td><?= htmlspecialchars($booking['notes']) ?></td>
          </tr>
          <?php endif; ?>
      </table>
      <br>
      <a href="index.html"><button>Back to Home</button></a>
      <br><br>
      <button onclick="window.print()">Print Receipt</button>
    </div>
  </section>




  
  <!-- COOKIE POPUP -->
  <div class="popup-overlay" id="cookiePopup">
    <div class="popup-box">
      <p>
        We use cookies to improve your experience on this site. 
        By continuing, you agree to our 
        <a href="legal.html#cookie-policy" target="_blank">Cookie Policy</a>.
      </p>
      <div class="cookie-buttons">
        <button id="acceptCookies">Accept</button>
        <button id="declineCookies">Decline</button>
      </div>
    </div>
  </div>

  <!-- RESET BUTTON -->
  <div class="footer-reset">
    <button id="resetCookies" class="hidden">Reset Cookies</button>
  </div>


  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-container">

      <div class="footer-about">
        <h3>Riget Zoo Adventures</h3>
        <p>Zoo and safari park since 1998.</p>
      </div>

      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="account.php">Account</a></li>
          <li><a href="legal.html">Legal</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>

      <div class="footer-social">
        <h4>Connect</h4>
        <div class="social-links">
          <a href="https://www.facebook.com" target="_blank" aria-label="Facebook">
            <img src="https://www.google.com/s2/favicons?sz=64&domain=facebook.com" alt="Facebook">
          </a>
          <a href="https://www.youtube.com/" target="_blank" aria-label="YouTube">
            <img src="https://www.google.com/s2/favicons?sz=64&domain=youtube.com" alt="YouTube">
          </a>
          <a href="https://x.com/" target="_blank" aria-label="Twitter">
            <img src="https://www.google.com/s2/favicons?sz=64&domain=twitter.com" alt="Twitter">
          </a>
          <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram">
            <img src="https://www.google.com/s2/favicons?sz=64&domain=instagram.com" alt="Instagram">
          </a>
          <a href="https://uk.linkedin.com/" target="_blank" aria-label="LinkedIn">
            <img src="https://www.google.com/s2/favicons?sz=64&domain=linkedin.com" alt="LinkedIn">
          </a>
        </div>
        <p>Email: <a href="mailto:info@example.com">info@example.com</a></p>
      </div>

    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Riget Zoo Adventures | All rights reserved</p>
    </div>
  </footer>


  <!-- ACCESSIBILITY TOOLBAR -->

  <script src="https://cdn.jsdelivr.net/gh/mickidum/acc_toolbar/acctoolbar/acctoolbar.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      if (!window.micAccessTool) {
        window.micAccessTool = new MicAccessTool({
          link: 'legal.html',
          contact: 'mailto:your-mail@your-awesome-website.com',
          buttonPosition: 'left', 
          forceLang: 'en' 
        });
      }
    });
  </script>

</body>
</html>
