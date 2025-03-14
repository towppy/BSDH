// Example user role (from PHP session or API)
const userRole = 'staff'; // Change to 'admin' or 'master'

// Toggle the visibility of a dropdown menu
const toggleDropdown = (dropdown, menu, isOpen) => {
  dropdown.classList.toggle("open", isOpen);
  menu.style.height = isOpen ? `${menu.scrollHeight}px` : 0;
};

// Close all open dropdowns
const closeAllDropdowns = () => {
  document.querySelectorAll(".dropdown-container.open").forEach((openDropdown) => {
    toggleDropdown(openDropdown, openDropdown.querySelector(".dropdown-menu"), false);
  });
};

// Attach click event to all dropdown toggles
document.querySelectorAll(".dropdown-toggle").forEach((dropdownToggle) => {
  dropdownToggle.addEventListener("click", (e) => {
    e.preventDefault();
    const dropdown = dropdownToggle.closest(".dropdown-container");
    const menu = dropdown.querySelector(".dropdown-menu");
    const isOpen = dropdown.classList.contains("open");
    closeAllDropdowns(); // Close all open dropdowns
    toggleDropdown(dropdown, menu, !isOpen); // Toggle current dropdown visibility
  });
});

// Attach click event to sidebar toggle buttons
document.querySelectorAll(".sidebar-toggler, .sidebar-menu-button").forEach((button) => {
  button.addEventListener("click", () => {
    closeAllDropdowns(); // Close all open dropdowns
    document.querySelector(".sidebar").classList.toggle("collapsed"); // Toggle collapsed class on sidebar
  });
});

// Collapse sidebar by default on small screens
if (window.innerWidth <= 1024) {
  document.querySelector(".sidebar").classList.add("collapsed");
}

// ===================== Role-Based Restriction for User Management =====================
const restrictUserOptions = () => {
  const staffOption = document.querySelector(".user-staff");
  const adminOption = document.querySelector(".user-admin");
  const patientOption = document.querySelector(".user-patient");

  if (userRole === 'staff') {
    staffOption.style.display = 'none';
    adminOption.style.display = 'none';
  } else if (userRole === 'admin') {
    adminOption.style.display = 'none';
  }
};

// Run the restriction on page load
restrictUserOptions();

// ===================== Dynamic Dashboard Redirection =====================
const dashboardLink = document.getElementById('dashboard-link');

if (userRole === 'master') {
  dashboardLink.href = '../Pages/masterhome.php';
} else if (userRole === 'admin') {
  dashboardLink.href = '../Pages/admhome.php';
} else if (userRole === 'staff') {
  dashboardLink.href = '../Pages/staffhome.php';
}
