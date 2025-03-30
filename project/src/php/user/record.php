<?php
    include("../auth/header-auth.php");

    session_start();
/* if (!isAuthenticatedUser()) {
    header("Location: ../auth/login.php");
    exit();
} */
include("../auth/connexion.php");
$errors = [];
$email = $_SESSION['email'];
$query = "SELECT * FROM user WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->bindParam(':email', $email);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $birthday = $_POST['birthday'];
    $patientGender = $_POST['patientGender'];
    $bloodGroup = $_POST['bloodGroup'];
    $familySituation = $_POST['familySituation'];
    $profession = $_POST['profession'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $phoneNumber2 = $_POST['phoneNumber2'];
    $assuranceNumber = $_POST['assuranceNumber'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $medicalHistory = $_POST['medicalHistory'];
    $surgicalHistory = $_POST['surgicalHistory'];
    $familyHistory = $_POST['familyHistory'];
    $otherHistory = $_POST['otherHistory'];

    if (empty($lastName)) {
        $errors['lastName'] = "Enter your last name .";
    }
    if (empty($firstName)) {
        $errors['firstName'] = "Enter your first name .";
    }
    if (empty($birthday)) {
        $errors['birthday'] = "Enter your birthday.";
    } else {
        // Check if the entered birthday is a valid date
        $birthdayDate = DateTime::createFromFormat('Y-m-d', $birthday);
        if (!$birthdayDate || $birthdayDate > new DateTime()) {
            $errors['birthday'] = "Invalid birthday date.";
        } else {
            // Calculate age
            $age = $birthdayDate->diff(new DateTime())->y;

            // Check if age is between 18 and 80
            if ($age < 18 || $age > 80) {
                $errors['birthday'] = "Age must be between 18 and 80.";
            }
        }
    }

    if (empty($patientGender)) {
        $errors['patientGender'] = "Enter your Gender .";
    }
    if (empty($bloodGroup)) {
        $errors['bloodGroup'] = "Enter your blood Group .";
    }
    if (empty($familySituation)) {
        $errors['familySituation'] = "Enter your family Situation .";
    }
    if (empty($profession)) {
        $errors['profession'] = "Enter your profession .";
    }
    if (empty($email)) {
        $errors['email'] = "Enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    if (empty($phoneNumber)) {
        $errors['phoneNumber'] = "Enter your phone Number .";
    }
    if (empty($assuranceNumber)) {
        $errors['assuranceNumber'] = "Enter your assurance Number .";
    }
    if (empty($address)) {
        $errors['address'] = "Enter your address .";
    }
    if (empty($errors)) {
        $insertQuery = "INSERT INTO consultation (id_user, lastName, firstName, birthday, patientGender, bloodGroup, familySituation, profession, email, phoneNumber, phoneNumber2, assuranceNumber, address, note, medicalHistory, surgicalHistory, familyHistory, otherHistory)
                        VALUES (:id_user, :lastName, :firstName, :birthday, :patientGender, :bloodGroup, :familySituation, :profession, :email, :phoneNumber, :phoneNumber2, :assuranceNumber, :address, :note, :medicalHistory, :surgicalHistory, :familyHistory, :otherHistory)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->bindParam(':id_user', $user_id);
        $insertStatement->bindParam(':lastName', $lastName);
        $insertStatement->bindParam(':firstName', $firstName);
        $insertStatement->bindParam(':birthday', $birthday);
        $insertStatement->bindParam(':patientGender', $patientGender);
        $insertStatement->bindParam(':bloodGroup', $bloodGroup);
        $insertStatement->bindParam(':familySituation', $familySituation);
        $insertStatement->bindParam(':profession', $profession);
        $insertStatement->bindParam(':email', $email);
        $insertStatement->bindParam(':phoneNumber', $phoneNumber);
        $insertStatement->bindParam(':phoneNumber2', $phoneNumber2);
        $insertStatement->bindParam(':assuranceNumber', $assuranceNumber);
        $insertStatement->bindParam(':address', $address);
        $insertStatement->bindParam(':note', $note);
        $insertStatement->bindParam(':medicalHistory', $medicalHistory);
        $insertStatement->bindParam(':surgicalHistory', $surgicalHistory);
        $insertStatement->bindParam(':familyHistory', $familyHistory);
        $insertStatement->bindParam(':otherHistory', $otherHistory);
        if ($insertStatement->execute()) {
            echo "<script>alert('Registration with success.')</script>";
            // Clear the form fields using JavaScript
            echo "<script>document.getElementById('registrationForm').reset();</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/user.css">
    <title>Medical Consultation</title>
</head>
<body>
<style>
    div#birthdayError {
        margin-top: 5px;
        color: red;
    }
</style>
<div class="container mt-5" style="margin-top: 9rem!important;">
    <div class="center-title">
        <h2 class="mb-4">Patient Record </h2>
    </div>
    <hr>

    <!-- Partie 1: Information Patient -->
    <form id="registrationForm" method="post" action="#">
        <div class="row">
            <div class="col-md-4">
                <h3><span> <img src="../../img/user-icon-2048x2048-ihoxz4vq.png" width="30"></span>Patient Information</h3>

                <div class="form-group">
                    <label for="lastName">Last Name:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg" id="lastName" name="lastName"
                           placeholder="Last Name"
                           maxlength="100" required>
                    <div id="lastNameError"
                         class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control form-control-lg" id="firstName" name="firstName"
                           placeholder="First Name" maxlength="100" required>
                    <div id="firstNameError"
                         class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday :<span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-lg" id="birthday" name="birthday"
                           placeholder="Birthday"
                           required>
                    <div id="birthdayError"
                         class="error-message"><?php echo isset($errors['birthday']) ? $errors['birthday'] : ''; ?></div>

                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="text" class="form-control form-control-lg" id="age" placeholder="Age" readonly>
                </div>
                <div class="form-group">
                    <label for="patientGender">Patient Gender:<span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg" id="patientGender" name="patientGender" required>
                        <option></option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <div id="patientGenderError"></div>
                </div>
                <div class="form-group">
                    <label for="bloodGroup">Blood Group:<span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg" id="bloodGroup" name="bloodGroup" required>
                        <option></option>
                        <option value="o+">O+</option>
                        <option value="o-">O-</option>
                        <option value="a+">A+</option>
                        <option value="a-">A-</option>
                        <option value="b+">B+</option>
                        <option value="b-">B-</option>
                        <option value="ab+">AB+</option>
                        <option value="ab-">AB-</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="familySituation">Family Situation :<span class="text-danger">*</span></label>
                    <select class="form-select form-select-lg" id="familySituation" name="familySituation" required>
                        <option></option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="profession">Profession :<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg" id="profession" name="profession"
                           placeholder="Profession"
                           maxlength="100" required>
                </div>
                <!-- Add other information patient fields here -->
            </div>
            <div class="col-md-4">
                <h3><span> <img src="../../img/phone.png" width="30"></span>Patient Contact Information</h3>
                <div class="form-group">
                    <label for="email">Email:<span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email"
                           maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number :<span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-lg" id="phoneNumber" name="phoneNumber"
                           placeholder="Phone Number"
                           maxlength="10" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber2">Phone Number 2:</label>
                    <input type="number" class="form-control form-control-lg" id="phoneNumber2" name="phoneNumber2"
                           placeholder="Phone Number 2" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="assuranceNumber">Assurance Number :<span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-lg" id="assuranceNumber"
                           name="assuranceNumber"
                           placeholder="Assurance Number" maxlength="10" required>

                </div>
                <div class="form-group">
                    <label for="address">Address :<span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-lg" id="address" name="address" placeholder="Address"
                              maxlength="1000" rows="3"
                              required>
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="note">Note :</label>
                    <textarea class="form-control form-control-lg" id="note" name="note" placeholder="Note"
                              maxlength="1000" rows="3">
                    </textarea>
                </div>
                <!-- Add other coordonnées patient fields here -->
            </div>
            <div class="col-md-4">
                <h3><span> <img src="../../img/antecedents.png" width="30"></span>Background</h3>
                <div class="form-group">
                    <label for="medicalHistory">Medical History :</label>
                    <textarea class="form-control form-control-lg" id="medicalHistory" name="medicalHistory"
                              placeholder="Medical History"
                              rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="surgicalHistory">Surgical History:</label>
                    <textarea class="form-control form-control-lg" id="surgicalHistory" name="surgicalHistory"
                              placeholder="Surgical History"
                              rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="familyHistory">familyHistory:</label>
                    <textarea class="form-control form-control-lg" id="familyHistory" name="familyHistory"
                              placeholder="Family History"
                              rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="otherHistory">Other History:</label>
                    <textarea class="form-control form-control-lg" id="otherHistory" name="otherHistory"
                              placeholder="Other History"
                              rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="row mt-4 right-buttons">
            <div class="col"></div>
            <div class="col">
                <button type="reset" class="button-34" role="button" style="background: #e35757;">Cancel</button>
                <button type="submit" class="button-34" role="button" style="background: #82E39C;">Save</button>
            </div>
        </div>
    </form>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Custom JavaScript for form validation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to calculate age from birthday
        function calculateAge() {
            var birthdayInput = document.getElementById("birthday");
            var ageInput = document.getElementById("age");

            // Check if the entered birthday is a valid date
            var birthdayDate = new Date(birthdayInput.value);
            if (!isNaN(birthdayDate.getTime())) {
                var today = new Date();
                var age = today.getFullYear() - birthdayDate.getFullYear();

                if (today.getMonth() < birthdayDate.getMonth() || (today.getMonth() === birthdayDate.getMonth() && today.getDate() < birthdayDate.getDate())) {
                    age--;
                }

                // Insert the calculated age into the "Age" field
                ageInput.value = age;
            }
        }

        // Attach the calculateAge function to the change event of the birthday input
        document.getElementById("birthday").addEventListener("change", calculateAge);

        document.getElementById("registrationForm").addEventListener("submit", function (event) {
            // Validate birthday on form submission
            var birthdayInput = document.getElementById("birthday");
            var birthdayError = document.getElementById("birthdayError");
            var birthdayDate = new Date(birthdayInput.value);
            var today = new Date();

            // Check if the entered birthday is a valid date
            if (isNaN(birthdayDate.getTime()) || birthdayDate > today) {
                birthdayError.innerHTML = "Invalid birthday date.";
                event.preventDefault(); // Cancel form submission
            } else {
                // Calculate age
                var age = today.getFullYear() - birthdayDate.getFullYear();
                if (today.getMonth() < birthdayDate.getMonth() || (today.getMonth() === birthdayDate.getMonth() && today.getDate() < birthdayDate.getDate())) {
                    age--;
                }

                // Check if age is between 18 and 80
                if (age < 18 || age > 80) {
                    birthdayError.innerHTML = "Age must be between 18 and 80.";
                    event.preventDefault(); // Cancel form submission
                } else {
                    // Clear previous error message and calculate age
                    birthdayError.innerHTML = "";
                    calculateAge();
                }
            }
        });
    });
</script>


<!--footer start-->
<?php
include("../auth/footer.php");
?>
<!--footer  end-->
</body>
</html>
