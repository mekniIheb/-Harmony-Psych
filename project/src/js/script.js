let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.navbar');
menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
}
window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
}


document.getElementById('contactForm').addEventListener('submit', function (event) {
    var isValid = true;

    // Function to display error messages
    function showError(id, message) {
        var errorElement = document.getElementById(id + 'Error');
        var inputElement = document.getElementById(id);
        errorElement.innerHTML = message;
        inputElement.classList.add('error');
        isValid = false;
    }

    // Function to clear error messages
    function clearError(id) {
        var errorElement = document.getElementById(id + 'Error');
        var inputElement = document.getElementById(id);
        errorElement.innerHTML = '';
        inputElement.classList.remove('error');
    }

    // Check firstname
    var firstname = document.getElementById('firstname').value;
    if (firstname.trim() === '') {
        showError('firstname', 'Please enter your firstname');
    } else {
        clearError('firstname');
    }

    // Check lastname
    var lastname = document.getElementById('lastname').value;
    if (lastname.trim() === '') {
        showError('lastname', 'Please enter your lastname');
    } else {
        clearError('lastname');
    }

    // Check phone number
    var phone = document.getElementById('phone').value;
    if (phone.trim() === '' || !/^\d+$/.test(phone)) {
        showError('phone', 'Please enter a valid phone number');
    } else {
        clearError('phone');
    }

    // Check email
    var email = document.getElementById('email').value;
    if (email.trim() === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError('email', 'Please enter a valid email address');
    } else {
        clearError('email');
    }

    // Check message
    var message = document.getElementById('message').value;
    if (message.trim() === '') {
        showError('message', 'Please enter your message');
    } else {
        clearError('message');
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission
    }
});