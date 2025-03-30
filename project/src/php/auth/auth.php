<?php
// auth.php
function isAuthenticatedAdmin() {
    return isset($_SESSION['email']) && $_SESSION['role'] == 1; // Assuming role 1 is for admin
}
function isAuthenticatedUser() {
    return isset($_SESSION['email']) && $_SESSION['role'] == 2; // Assuming role 1 is for admin
}

?>
