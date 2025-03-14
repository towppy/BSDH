<?php
ob_start();
session_start();
include '../database.php';

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sanitize input function
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error_message = ""; 
$success_message = ""; 

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // LOGIN FUNCTIONALITY
    if (isset($_POST['id_number'], $_POST['password'])) {
        $id_number = sanitizeInput($_POST['id_number']);
        $password = sanitizeInput($_POST['password']);

        if (empty($id_number) || empty($password)) {
            $error_message = "Please enter both ID number and password.";
        } else {
            $stmt = $conn->prepare("SELECT user_id, id_number, password, role, IFNULL(name, 'No Name') AS name FROM users WHERE id_number = ?");

            $stmt->bind_param("s", $id_number);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
            
                // Store user data in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['id_number'] = $user['id_number'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
            
                // Redirect based on user role
                switch ($user['role']) {
                    case 'master':
                        header("Location: ../Pages/masterhome.php");
                        break;
                    case 'admin':
                        header("Location: ../Pages/admhome.php");
                        break;
                    case 'doctor':
                        header("Location: ../Pages/staffhome.php");
                        break;
                    case 'nurse':
                        header("Location: ../Pages/staffhome.php");
                        break;
                    default:
                        $error_message = "Invalid role.";
                }
                exit();
            
            
            } else {
                $error_message = "Invalid credentials. Please try again.";
            }
        }
    }

    // APPOINTMENT BOOKING FUNCTIONALITY
    if (isset($_POST['book_appointment'])) {
        $full_name = sanitizeInput($_POST['full_name']);
        $email = sanitizeInput($_POST['email']);
        $appointment_date = sanitizeInput($_POST['appointment_date']);
        $description = sanitizeInput($_POST['category']);

        // Validate the appointment type
        $allowed_descriptions = ['Consultation', 'Dental', 'Prenatal'];
        if (!in_array($description, $allowed_descriptions)) {
            $error_message = "Invalid appointment type.";
        } else {
            // Handle File Upload
            $id_image = $_FILES['id_image'];
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($id_image["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is an image
            $check = getimagesize($id_image["tmp_name"]);
            if ($check === false) {
                $error_message = "File is not an image.";
            } elseif ($id_image["size"] > 5000000) { // File size check (max 5MB)
                $error_message = "File is too large.";
            } elseif (!in_array($imageFileType, ["jpg", "png", "jpeg"])) { // Allowed file formats
                $error_message = "Only JPG, JPEG & PNG files are allowed.";
            } else {
                // Upload file
                if (move_uploaded_file($id_image["tmp_name"], $target_file)) {
                    // Insert appointment data into the database
                    $stmt = $conn->prepare("INSERT INTO appointments (full_name, email, appointment_date, id_image, description) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $full_name, $email, $appointment_date, $target_file, $description);
                    if ($stmt->execute()) {
                        $success_message = "Your appointment has been successfully booked!";
                        header("Location: ../Pages/home.php");
                        exit();
                    } else {
                        $error_message = "Failed to book appointment.";
                    }
                    $stmt->close();
                } else {
                    $error_message = "Error uploading file.";
                }
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSDH System</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="../JS/login.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="../Images/sdlogo.png" alt="logo">
                <h2>BSDH</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
            
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
            <div class="nav-buttons">
                <button class="login-btn">LOG IN</button>
                <button class="consul-btn">SCHEDULE</button>
            </div>
            
        </nav>
    </header>

    <div class="info-box">
    <p> 
"Your health is our priority. At BSDH, we are committed to providing quality and compassionate healthcare services 
tailored to your needs. Our experienced medical professionals are dedicated to ensuring your well-being, whether through routine check-ups, 
specialized treatments, or preventive care. We offer a wide range of medical services, including general consultations, diagnostic procedures,
 emergency care, and wellness programs. With state-of-the-art facilities and a patient-centered approach, we strive to create a safe and comfortable environment
  for you and your loved ones. Your journey to better health starts here—schedule an appointment today and take a proactive step towards a healthier future."
</p>
    <button class="learn-more-btn">Learn More</button>
</div>


    <div class="blur-bg-overlay"></div>

    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>

        
<?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
        <!-- LOGIN FORM -->
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please log in using your personal information to stay connected with us.</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="login.php" method="post">

                <div class="input-field">
    <input type="text" name="id_number" required>
    <label>ID Number</label>
</div>
<div class="input-field">
    <input type="password" name="password" required>
    <label>Password</label>
</div>

                    <a href="#" class="forgot-pass-link">Forgot password?</a>
                    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Want to schedule an appointment without an account?  
                    <a href="appointment.php" id="appointment-link">Book an Appointment</a>
                </div>
            </div>
        </div>

        <!-- SIGNUP FORM -->
        <div class="form-box signup">
            <div class="form-details">
                <h2>Create Account</h2>
                <p>To become a part of our community, please sign up using your personal information.</p>
            </div>
            <div class="form-content">
                <h2>SIGNUP</h2>
                <form action="#">
                    <div class="input-field">
                        <input type="text" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" required>
                        <label>Create password</label>
                    </div>
                    <div class="policy-text">
                        <input type="checkbox" id="policy">
                        <label for="policy">
                            I agree to the
                            <a href="#" class="option">Terms & Conditions</a>
                        </label>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div class="bottom-link">
                    Already have an account?  
                    <a href="#" id="login-link">Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<!-- Appointment Booking Popup -->
<div class="form-popup appointment">
    <span class="close-btn material-symbols-rounded">close</span>
    <div class="form-box">
        <div class="form-details">
            <h2>Book an Appointment</h2>
            <p>Fill in the details to schedule your appointment.</p>
        </div>
        <div class="form-content">
            <h2>Appointment Form</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <input type="text" name="full_name" required>
                    <label>Full Name</label>
                </div>

                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email Address</label>
                </div>
              
                <div class="input-field">
                    <input type="file" name="id_image" accept="image/*" required>
                    <label>Upload Your ID For Verification</label>
                </div>
                
                <div class="input-field">
                    <input type="date" name="appointment_date" id="appointment_date" required>
                </div>

                <div class="input-field">
                    <select name="category" required>
                        <option value="Consultation">Consultation</option>
                        <option value="Dental">Dental</option>
                        <option value="Prenatal">Pre Natal</option>
                    </select>
                </div>
                <button type="submit" name="book_appointment">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Disabled Previous and Current Date -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get today's date
        let today = new Date();
        
        // Set tomorrow's date (disable today and previous dates)
        today.setDate(today.getDate() + 1);

        // Format date to YYYY-MM-DD
        let tomorrow = today.toISOString().split('T')[0];

        // Set the min attribute to disable past and current dates
        document.getElementById("appointment_date").min = tomorrow;
    });
</script>