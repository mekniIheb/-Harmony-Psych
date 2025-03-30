<?php
include("../auth/header-auth.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../auth/connexion.php");

$email = $_SESSION['email'];
$query = "SELECT * FROM user WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->bindParam(':email', $email);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFirstName = htmlspecialchars(trim($_POST['editFirstName']));
    $newLastName = htmlspecialchars(trim($_POST['editLastName']));
    $newPassword = htmlspecialchars(trim($_POST['newPassword']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } elseif (strlen($newPassword) < 8) {
        echo "<script>alert('Password should be at least 8 characters long.');</script>";
    } else {
        // Hash the new password before updating
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update profile information
        $updateQuery = "UPDATE user SET prenom = :newFirstName, nom = :newLastName, password = :hashedPassword WHERE email = :email";
        $updateStatement = $pdo->prepare($updateQuery);
        $updateStatement->bindParam(':newFirstName', $newFirstName);
        $updateStatement->bindParam(':newLastName', $newLastName);
        $updateStatement->bindParam(':hashedPassword', $hashedPassword);
        $updateStatement->bindParam(':email', $email);

        if ($updateStatement->execute()) {
            echo "<script>alert('Profile updated successfully.');</script>";
        } else {
            echo "<script>alert('Error: Unable to update profile.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../../css/editProfile.css">
</head>
<body>

<div class="edit-profile-container">
    <h2>Edit Profile</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="editFirstName">First Name:</label>
            <input class="form-control form-control-lg" type="text" id="editFirstName" name="editFirstName" value="<?php echo $user['prenom']; ?>" required>
        </div>
        <div class="form-group">
            <label for="editLastName">Last Name:</label>
            <input class="form-control form-control-lg" type="text" id="editLastName" name="editLastName" value="<?php echo $user['nom']; ?>" required>
        </div>
        <div class="form-group">
            <label for="editEmail">Email:</label>
            <input class="form-control form-control-lg" type="email" id="editEmail" name="editEmail" value="<?php echo $user['email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <div class="password-input-container">
                <input class="form-control form-control-lg" type="password" id="newPassword" name="newPassword" required>
                <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility('newPassword')"></i>
            </div>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-input-container">
                <input class="form-control form-control-lg" type="password" id="confirmPassword" name="confirmPassword" required>
                <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility('confirmPassword')"></i>
            </div>
        </div>
        <div class="row mt-4 right-buttons">
            <div class="col"></div>
            <div class="col">
                <button type="button" class="button-34" role="button" style="background: #e35757;">Cancel</button>
                <button type="submit" class="button-34" role="button" style="background: #82E39C;">Save</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = passwordInput.nextElementSibling;

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<!--footer start-->
<?php
include("../auth/footer.php");
?>
<!--footer  end-->
</body>
</html>
