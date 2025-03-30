<?php
session_start();
include("connexion.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    if (empty($nom)) {
        $errors['nom'] = "Enter your nom";
    }

    if (empty($prenom)) {
        $errors['prenom'] = "Enter your prenom";
    }

    if (empty($email)) {
        $errors['email'] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else {
        // Check if the email already exists in the database
        $query = "SELECT id FROM user WHERE email = :email";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $existingUser = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $errors['email'] = "Email already in use. Choose a different email.";
        }
    }

    if (empty($password)) {
        $errors['password'] = "Enter your password";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    }

    if (empty($confirmPassword)) {
        $errors['confirm_password'] = "Confirm your password";
    } elseif ($password != $confirmPassword) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (email, password, nom, prenom, role) VALUES (:email, :password, :nom, :prenom, 2)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $hashedPassword);
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);

        if ($statement->execute()) {
            echo "<script>alert('Registration successful. You can now log in.')</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/login.css">
    <title>Sign up</title>
</head>

<body>

<div class="login-container">
    <form action="#" method="post" class="login-form" onsubmit="return validateForm()">
        <h2>Sign up</h2>

        <div class="custom-alert" id="error-messages"></div>

        <input type="text" id="nom" name="nom" placeholder="Nom">
        <div class="error-message" id="error-nom"><?php echo isset($errors['nom']) ? $errors['nom'] : ''; ?></div>

        <input type="text" id="prenom" name="prenom" placeholder="Prenom">
        <div class="error-message" id="error-prenom"><?php echo isset($errors['prenom']) ? $errors['prenom'] : ''; ?></div>

        <input type="email" id="mail" name="mail" placeholder="Email">
        <div class="error-message" id="error-email"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>

        <input type="password" id="password" name="password" placeholder="Create password">
        <div class="error-message" id="error-password"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div>

        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password">
        <div class="error-message" id="error-confirm-password"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></div>

        <button type="submit">Sign up</button>
        <p class="msg">Already have an account? <a href="login.php">Log in</a></p>
    </form>
</div>

<style>
    .error-message {
        color: red;
        margin-top: 5px;
    }

    .custom-alert {
        color: #fff;
        background-color: #28a745; /* Green background color */
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 15px;
        display: none; /* Hide by default */
    }
</style>

<script>
    function showCustomAlert(message, success) {
        var customAlert = document.getElementById('error-messages');
        customAlert.textContent = message;

        if (success) {
            customAlert.style.backgroundColor = '#28a745';
        } else {
            customAlert.style.backgroundColor = '#dc3545';
        }

        customAlert.style.display = 'block';

        setTimeout(function () {
            customAlert.style.display = 'none';
        }, 3000);
    }

    function validateForm() {
        var nom = document.getElementById('nom').value;
        var prenom = document.getElementById('prenom').value;
        var email = document.getElementById('mail').value;
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;

        var errors = [];

        if (nom.trim() === '') {
            errors.push('Enter your nom');
            document.getElementById('error-nom').textContent = 'Enter your nom';
        } else {
            document.getElementById('error-nom').textContent = '';
        }

        if (prenom.trim() === '') {
            errors.push('Enter your prenom');
            document.getElementById('error-prenom').textContent = 'Enter your prenom';
        } else {
            document.getElementById('error-prenom').textContent = '';
        }

        if (email.trim() === '') {
            errors.push('Enter your email');
            document.getElementById('error-email').textContent = 'Enter your email';
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
            errors.push('Invalid email format');
            document.getElementById('error-email').textContent = 'Invalid email format';
        } else {
            document.getElementById('error-email').textContent = '';
        }

        if (password.trim() === '') {
            errors.push('Enter your password');
            document.getElementById('error-password').textContent = 'Enter your password';
        } else if (password.length < 6) {
            errors.push('Password must be at least 6 characters long');
            document.getElementById('error-password').textContent = 'Password must be at least 6 characters long';
        } else {
            document.getElementById('error-password').textContent = '';
        }

        if (confirmPassword.trim() === '') {
            errors.push('Confirm your password');
            document.getElementById('error-confirm-password').textContent = 'Confirm your password';
        } else if (confirmPassword !== password) {
            errors.push('Passwords do not match');
            document.getElementById('error-confirm-password').textContent = 'Passwords do not match';
        } else {
            document.getElementById('error-confirm-password').textContent = '';
        }

        if (errors.length > 0) {
            showCustomAlert('Form validation failed. Please check the errors.', false);
            return false;
        }

        return true;
    }
</script>

</body>

</html>
