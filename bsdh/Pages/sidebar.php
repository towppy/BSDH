<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start(); 
}

$role = $_SESSION['role'] ?? 'guest';
$specialization = '';

if ($role === 'doctor') {
  // Connect to the database
  include '../database.php'; // Your database connection file

  $user_id = $_SESSION['user_id']; // Your logged-in user's ID

  // Fetch the specialization from the doctors table
  $query = "SELECT specialization FROM doctors WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $specialization = $row['specialization'] ?? '';
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../CSS/sidebar.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  </head>
  <body>
    <button class="sidebar-menu-button">
      <span class="material-symbols-rounded">menu</span>
    </button>
    <aside class="sidebar">
      <header class="sidebar-header">
        <button class="sidebar-toggler">
          <span class="material-symbols-rounded">chevron_left</span>
        </button>
      </header>
      <nav class="sidebar-nav">
        <ul class="nav-list primary-nav">
          <li class="nav-item">
            <a href="
              <?php
                if ($role === 'master') {
                  echo '../Pages/masterhome.php';
                } elseif ($role === 'admin') {
                  echo '../Pages/admhome.php';
                } elseif ($role === 'doctor') {
                  echo '../Pages/staffhome.php';
                } elseif ($role === 'nurse') {
                  echo '../Pages/staffhome.php';
                } else {
                  echo '#';
                }
              ?>" class="nav-link">
              <span class="material-symbols-rounded">dashboard</span>
              <span class="nav-label">Dashboard</span>
            </a>
          </li>
          
          <?php if ($role === 'master' || $role === 'admin'): ?>
<li class="nav-item dropdown-container">
  <a href="#" class="nav-link dropdown-toggle">
    <span class="material-symbols-rounded">inventory_2</span>
    <span class="nav-label">Inventory</span>
    <span class="dropdown-icon material-symbols-rounded">keyboard_arrow_down</span>
  </a>
  <ul class="dropdown-menu">
    <li class="nav-item"><a href="../Pharmacy/p_inventory.php" class="nav-link dropdown-link">Pharmacy</a></li>
    <li class="nav-item"><a href="../MEI/inventory.php" class="nav-link dropdown-link">Medical Equipment</a></li>
  </ul>
</li>
<?php endif; ?>


          <li class="nav-item dropdown-container">
  <a href="#" class="nav-link dropdown-toggle">
    <span class="material-symbols-rounded">medical_services</span>
    <span class="nav-label">Medical Records</span>
    <span class="dropdown-icon material-symbols-rounded">keyboard_arrow_down</span>
  </a>
  <ul class="dropdown-menu">
    <?php if ($role === 'master' || $role === 'admin' || $role === 'nurse' || $specialization === 'General' || $specialization === 'Consultation'): ?>
      <li class="nav-item"><a href="../MedRec/consulmed.php" class="nav-link dropdown-link">Consultation</a></li>
    <?php endif; ?>
    
    <?php if ($role === 'master' || $role === 'admin' || $role === 'nurse' || $specialization === 'General' || $specialization === 'Dental'): ?>
      <li class="nav-item"><a href="../MedRec/denmed.php" class="nav-link dropdown-link">Dental</a></li>
    <?php endif; ?>

    <?php if ($role === 'master' || $role === 'admin' || $role === 'nurse' || $specialization === 'General' || $specialization === 'Prenatal'): ?>
      <li class="nav-item"><a href="../MedRec/prenatmed.php" class="nav-link dropdown-link">Pre Natal</a></li>
    <?php endif; ?>
  </ul>
</li>

<li class="nav-item dropdown-container">
  <a href="#" class="nav-link dropdown-toggle">
    <span class="material-symbols-rounded">calendar_today</span>
    <span class="nav-label">Report</span>
    <span class="dropdown-icon material-symbols-rounded">keyboard_arrow_down</span>
  </a>
  <ul class="dropdown-menu">
    <?php if ($role === 'master' || $role === 'admin' || $specialization === 'General' || $specialization === 'Consultation'): ?>
      <li class="nav-item"><a href="../Reports/Consultation.php" class="nav-link dropdown-link">Consultation</a></li>
    <?php endif; ?>

    <?php if ($role === 'master' || $role === 'admin' || $specialization === 'General' || $specialization === 'Dental'): ?>
      <li class="nav-item"><a href="../Reports/Dental.php" class="nav-link dropdown-link">Dental</a></li>
    <?php endif; ?>

    <?php if ($role === 'master' || $role === 'admin' || $specialization === 'General' || $specialization === 'Prenatal'): ?>
      <li class="nav-item"><a href="../Reports/Prenat.php" class="nav-link dropdown-link">Pre Natal</a></li>
    <?php endif; ?>
  </ul>
</li>

          <li class="nav-item dropdown-container">
            <a href="#" class="nav-link dropdown-toggle">
              <span class="material-symbols-rounded">manage_accounts</span>
              <span class="nav-label">User Management</span>
              <span class="dropdown-icon material-symbols-rounded">keyboard_arrow_down</span>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item"><a class="nav-link dropdown-title">User Management</a></li>
              <?php if ($role === 'master' || $role === 'admin'): ?>
                <li class="nav-item"><a href="../UM/umstaff.php" class="nav-link dropdown-link">Staff</a></li>
              <?php endif; ?>
              <?php if ($role === 'master'): ?>
                <li class="nav-item"><a href="../UM/umadmin.php" class="nav-link dropdown-link">Admins</a></li>
              <?php endif; ?>
              <li class="nav-item"><a href="../UM/umpatients.php" class="nav-link dropdown-link">Patients</a></li>
            </ul>
          </li>
        </ul>

        <ul class="nav-list secondary-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="material-symbols-rounded">help</span>
              <span class="nav-label">Support</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="../Users/logout.php" class="nav-link">
              <span class="material-symbols-rounded">logout</span>
              <span class="nav-label">Sign Out</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <script src="../JS/sidebar.js"></script>
  </body>
</html>
