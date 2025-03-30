<?php
session_start();
include("connexion.php");

$errors = array();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errors['email'] = "Enter your email";
    }
    if (empty($password)) {
        $errors['password'] = "Enter your password";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM user WHERE email=:email";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':email', $email);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['password'])) {
                $_SESSION['email'] = $result['email'];
                $_SESSION['role'] = $result['role'];

                if ($_SESSION['role'] == 1) {
                    // Admin role
                    header("location: ../admin/admin.php");
                    exit();
                } elseif ($_SESSION['role'] == 2) {
                    // User role
                    header("location: ../user/homeUser.php");
                    exit();
                } else {
                    // Handle other roles if needed
                    echo "<script>alert('Invalid role')</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password')</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password')</script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN1T+2vqADP+FFQFnpDZR0inl0EhF7Dip" crossorigin="anonymous">
    <title>Login Page</title>
</head>
<body>

<div class="login-container">
    <form method="post" class="login-form">
        <h2>Login</h2>
        <div>
        <input type="email" id="email" name="email" placeholder="Enter your email">
        <input type="password" id="password" name="password" placeholder="Enter your password">
        <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility('password')"></i>
        <?php if (!empty($errors['email']) || !empty($errors['password']) || !empty($errors['invalid'])): ?>
            <div class="alert alert-danger">
                <?php
                if (isset($errors['email'])) {
                    echo "<h4 class='alert alert-danger'>" . $errors['email'] . "</h4>";
                }
                if (isset($errors['password'])) {
                    echo "<h4 class='alert alert-danger'>" . $errors['password'] . "</h4>";
                }
                if (isset($errors['invalid'])) {
                    echo "<h4 class='alert alert-danger'>" . $errors['invalid'] . "</h4>";
                }
                ?>
            </div>
        <?php endif; ?>
        <button type="submit" name="submit">Login</button>
        <p class="msg">Don't have an account <a href="signup.php">sign up</a></p>
    </form>
</div>

<script>
    function togglePasswordVisibility(passwordFieldId) {
        var passwordField = document.getElementById(passwordFieldId);
        var icon = document.querySelector('.toggle-password');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('.login-form');
        var email = document.getElementById('email');
        var passwordInput = document.getElementById('password');

        form.addEventListener('submit', function (event) {
            var isFormValid = true;

            if (email.value.trim() === '') {
                displayError(email, 'Please enter your email.');
                isFormValid = false;
            } else {
                hideError(email);
            }

            if (passwordInput.value.trim() === '') {
                displayError(passwordInput, 'Please enter your password.');
                isFormValid = false;
            } else {
                hideError(passwordInput);
            }

            if (!isFormValid) {
                event.preventDefault();
            }
        });

        function displayError(inputElement, errorMessage) {
            var errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            errorElement.textContent = errorMessage;

            var parentElement = inputElement.parentNode;
            parentElement.appendChild(errorElement);

            inputElement.classList.add('error-input');
        }

        function hideError(inputElement) {
            var parentElement = inputElement.parentNode;
            var errorElement = parentElement.querySelector('.error-message');

            if (errorElement) {
                parentElement.removeChild(errorElement);
            }

            inputElement.classList.remove('error-input');
        }
    });
</script>

</body>
</html>
