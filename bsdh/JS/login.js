const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const showPopupBtn = document.querySelector(".login-btn");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");
// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});
// Hide mobile menu
hideMenuBtn.addEventListener("click", () =>  hamburgerBtn.click());
// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
});
// Hide login popup
hidePopupBtn.addEventListener("click", () => showPopupBtn.click());
// Show or hide signup form
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        formPopup.classList[link.id === 'signup-link' ? 'add' : 'remove']("show-signup");
    });
});

//APPOINTMENT BOOKING

const appointmentPopup = document.querySelector(".form-popup.appointment");
const bookAppointmentBtn = document.querySelector(".consul-btn");
const closeAppointmentBtn = appointmentPopup.querySelector(".close-btn");

bookAppointmentBtn.addEventListener("click", () => {
    appointmentPopup.classList.add("show");
});


closeAppointmentBtn.addEventListener("click", () => {
    appointmentPopup.classList.remove("show");
});

document.querySelector("form").addEventListener("submit", function(event) {
    let idNumber = document.querySelector('input[name="id_number"]').value.trim();
    let password = document.querySelector('input[name="password"]').value.trim();

    if (idNumber === "" || password === "") {
        alert("Please enter both ID Number and Password.");
        event.preventDefault(); // Stop form submission
        return;
    }

    console.log("Form submitted!"); // Check if it logs in the console
});


