// Show the success popup (trigger this after form submission success)
document.getElementById("appointment-success-popup").style.display = "flex";

// Close the success popup when the button is clicked
document.getElementById("close-popup-btn").addEventListener("click", function() {
    document.getElementById("appointment-success-popup").style.display = "none";
});