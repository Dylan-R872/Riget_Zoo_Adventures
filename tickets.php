<?php

// Start session and check login state
session_start();

$isLoggedIn = isset($_SESSION['cust_id']);
$Name   = $isLoggedIn ? htmlspecialchars($_SESSION['name']) : '';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>RZA | Ticket Admission</title>
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

  
  <section class="account-section">

    <?php if($isLoggedIn): ?>


      <!-- TICKET BOOKING BOX -->
      <div class="account-box active" id="booking-box">
        <h2>Ticket Bookings</h2>

        <form action="tickets_process.php" method="POST" class="booking-form">
            <input type="hidden" name="cust_id" value="<?php echo $_SESSION['cust_id']; ?>">

            <div class="form-row">
                <label>Admission Date</label>
                <input type="date" name="admission" required>
            </div>
            <div class="form-row">
                <label>Ticket Type</label>
                <select name="ticket_type" required>
                    <option value="">Select Type</option>
                    <option value="Day">Day Pass</option>
                    <option value="Weekend">Weekend Pass</option>
                    <option value="Annual">Annual Pass</option>
                    <option value="VIP">VIP Exclusive Pass</option>
                </select>
            </div>
            
            <div class="form-row">
                <label>Adult Tickets</label>
                <input type="number" name="adult_ticket" min="0" max="30" required>
            </div>
            <div class="form-row">
                <label>Child Tickets</label>
                <input type="number" name="child_ticket" min="0" max="30" required>
            </div>
            
            <button type="submit" class="booking-btn">Confirm Booking</button>
        </form>


      <!-- USER MUST BE LOGGED IN -->
    <?php else: ?>
        <div style="text-align:center; padding:40px;">
          <h2>Login Required</h2>
          <p>You must be logged in to make a booking.</p>
          <a href="account.php">
            <button style="padding:10px 20px;">Go to Login</button>
          </a>
        </div>
    <?php endif; ?>
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





