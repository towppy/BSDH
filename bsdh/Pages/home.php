
<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../Users/login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BSDH System -- HOME</title>
    <!-- Linking Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <!-- Linking Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../CSS/home.css" />
  </head>
  <body>
    <!-- Header / Navbar -->
    <header>
      <nav class="navbar">
        <a href="#" class="nav-logo">
          <h2 class="logo-text">BSDH</h2>
        </a>
        <ul class="nav-menu">
          <button id="menu-close-button" class="fas fa-times"></button>
          <li class="nav-item">
            <a href="#" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="#menu" class="nav-link">Services</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-link">Contact</a>
          </li>
          <li class="nav-item">
            <a href="../Users/login.php" class="nav-link">Main Menu</a>
          </li>
        </ul>
        <button id="menu-open-button" class="fas fa-bars"></button>
      </nav>
    </header>
    <main>


      <div class="popup-message" id="appointment-success-popup">
        <div class="popup-content">
            <h3>Appointment Registered Successfully!</h3>
            <p>Please wait for a confirmation email.</p>
            <button id="close-popup-btn">Close</button>
        </div>
      </div>

      <script>
        
        document.getElementById("appointment-success-popup").style.display = "block";


        document.getElementById("close-popup-btn").addEventListener("click", function() {
            document.getElementById("appointment-success-popup").style.display = "none";
        });
      </script>

      <!-- Hero section -->
      <section class="hero-section">
        <div class="section-content">
          <div class="hero-details">
            <h1 class="title">Welcome!</h1>
            <h3 class="subtitle">BSDHS – Your Trusted Partner in Healthcare</h3>
          </div>
        </div>
      </section>

      <!-- About section -->
      <section class="about-section" id="about">
        <div class="section-content">
          <div class="about-details">
            <h2 class="section-title">About Us</h2>
            <p class="text">
              At BSDHS, we are committed to providing accessible, efficient, and patient-centered healthcare services. Our platform streamlines appointment scheduling, medical record management, and consultations, ensuring a seamless experience for both patients and healthcare providers.  
              Whether you're booking a consultation, accessing medical history, or managing clinic operations, our system is designed to make healthcare simple and convenient. Stay connected with your health anytime, anywhere.  
              Explore our services and take the next step toward better healthcare today!
            </p>
          </div>
        </div>
      </section>

      <!-- Menu section -->
      <section class="menu-section" id="menu">
        <h2 class="section-title">Our Services</h2>
        <div class="section-content">
          <ul class="menu-list">
            <li class="menu-item">
              <img src="../Images/consultation.jpg" alt="consultation" class="menu-image" />
              <div class="menu-details">
                <h3 class="name">Consultations</h3>
                <p class="text">Register now to have your free health check up</p>
              </div>
            </li>
            <li class="menu-item">
              <img src="../Images/dental.jpg" alt="dental" class="menu-image" />
              <div class="menu-details">
                <h3 class="name">Dental Care</h3>
                <p class="text">For all your dental care needs</p>
              </div>
            </li>
            <li class="menu-item">
              <img src="../Images/pregnancy.jpg" alt="pregnancy" class="menu-image" />
              <div class="menu-details">
                <h3 class="name">Prenatal Care</h3>
                <p class="text">Fruit and icy refreshing drink to make feel refreshed.</p>
              </div>
            </li>
            <li class="menu-item">
              <img src="../Images/otherc.jpg" alt="otherconcerns" class="menu-image" />
              <div class="menu-details">
                <h3 class="name">Other Concerns</h3>
                <p class="text">Feel free to visit our clinic after registering</p>
              </div>
            </li>
          </ul>
        </div>
      </section>

      <!-- Contact section -->
      <section class="contact-section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="section-content">
          <ul class="contact-info-list">
            <li class="contact-info">
              <i class="fa-solid fa-location-crosshairs"></i>
              <p>F2CX+P8W, Taguig, Metro Manila</p>
            </li>
            <li class="contact-info">
              <i class="fa-regular fa-envelope"></i>
              <p>healthcenter1234@gmail.com</p>
            </li>
            <li class="contact-info">
              <i class="fa-solid fa-phone"></i>
              <p>(123) 456-78909</p>
            </li>
            <li class="contact-info">
              <i class="fa-regular fa-clock"></i>
              <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
            </li>
            <li class="contact-info">
              <i class="fa-regular fa-clock"></i>
              <p>Saturday: 10:00 AM - 3:00 PM</p>
            </li>
            <li class="contact-info">
              <i class="fa-regular fa-clock"></i>
              <p>Sunday: Closed</p>
            </li>
          </ul>
        </div>
      </section>

      <!-- Footer section -->
      <footer class="footer-section">
        <div class="section-content">
          <p class="copyright-text">Health Center System</p>
          <div class="social-link-list">
            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
          </div>
          <p class="policy-text">
            <a href="#" class="policy-link">Privacy policy</a>
            <span class="separator">•</span>
            <a href="#" class="policy-link">Refund policy</a>
          </p>
        </div>
      </footer>
    </main>

    <!-- Linking Swiper script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Linking custom script -->
    <script src="script.js"></script>
    <!-- Including conf.js -->
    <script src="conf.js"></script>
  </body>
</html>
