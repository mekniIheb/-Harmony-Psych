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
    // Validate and sanitize form inputs
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $appointmentDate = htmlspecialchars(trim($_POST['appointmentDate']));
    $selectedTime = htmlspecialchars(trim($_POST['selectedTime'])); // Add this line
    $reason = htmlspecialchars(trim($_POST['reason']));

// Check if the combination of appointmentDate and selectedTime is unique
    $checkQuery = "SELECT COUNT(*) FROM rendezvous WHERE appointmentDate = :appointmentDate AND selectedTime = :selectedTime";
    $checkStatement = $pdo->prepare($checkQuery);
    $checkStatement->bindParam(':appointmentDate', $appointmentDate);
    $checkStatement->bindParam(':selectedTime', $selectedTime);
    $checkStatement->execute();
    $count = $checkStatement->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Appointment already exists for the selected date and time. Please choose a different time.')</script>";
    } else {
        // Insert data into the "rendezvous" table
        $insertQuery = "INSERT INTO rendezvous (firstName, lastName, phoneNumber, appointmentDate, selectedTime, reason, user_id) 
                    VALUES (:firstName, :lastName, :phoneNumber, :appointmentDate, :selectedTime, :reason, :user_id)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->bindParam(':firstName', $firstName);
        $insertStatement->bindParam(':lastName', $lastName);
        $insertStatement->bindParam(':phoneNumber', $phoneNumber);
        $insertStatement->bindParam(':appointmentDate', $appointmentDate);
        $insertStatement->bindParam(':selectedTime', $selectedTime);
        $insertStatement->bindParam(':reason', $reason);
        $insertStatement->bindParam(':user_id', $user_id);

        if ($insertStatement->execute()) {
            echo "<script>alert('Appointment saved successfully.')</script>";
        } else {
            echo "<script>alert('Error: Unable to save appointment.')</script>";
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
    <link rel="stylesheet" href="../../css/appointment.css">
    <title>Appointment Management</title>
</head>
<body>
<style>
    textarea.form-control {
        height: 80px;
    }

    label {
        font-size: larger;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .button-34 {

        border-radius: 999px;
        box-shadow: #ababab 0 10px 20px -10px;
        box-sizing: border-box;
        color: #ffffff;
        cursor: pointer;
        font-family: Inter, Helvetica, "Apple Color Emoji", "Segoe UI Emoji", NotoColorEmoji, "Noto Color Emoji", "Segoe UI Symbol", "Android Emoji", EmojiSymbols, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", sans-serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 24px;
        opacity: 1;
        outline: 0 solid transparent;
        padding: 8px 18px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: fit-content;
        word-break: break-word;
        border: 0;
    }

    .availabilities-slot {
        padding-left: 0 !important;
        padding-right: 0 !important;
        white-space: nowrap;
        width: 21% !important;
    }

    .availabilities-slot {
        position: inherit !important;
        float: left;
        margin: 5px;
        padding: 8px 12px;
        font-size: 16px;
        width: 75% !important;
    }

    .availabilities-slot {
        position: relative;
        width: 100%;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        line-height: 16px;
        color: #adb5bd;
        padding: 7px 0;
        margin-bottom: 10px;
        border: 1px solid transparent;
        background-color: #0d6efd;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -moz-transition: all .25s ease;
        -webkit-transition: all .25s ease;
        transition: all .25s ease;
    }
</style>
<div class="container mt-5" style="margin-top: 9rem!important;width: 60%">
    <div class="centre-title">
        <h2 class="mb-4"><span><img src="../../img/appointement.png" width="40"></span>schedule an appointment</h2>
    </div>
    <hr style=" border-top: 1px solid #000;">
    <form id="appointmentForm" method="post">
        <div class="form-row centre-title">
            <div class="form-group col">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control form-control-lg" id="firstName" name="firstName" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="phoneNumber">Phone Number:</label>
                <input type="number" class="form-control form-control-lg" id="phoneNumber" name="phoneNumber" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="appointmentDate">Appointment Date:</label>
                <input type="date" class="form-control form-control-lg" id="appointmentDate"
                       name="appointmentDate" required>
            </div>
        </div>
        <input type="hidden" id="selectedTime" name="selectedTime">
        <div class="form-row">
            <div class="form-group col">
                <label for="appointmentDate">Please choose the appointment time:</label>
                <div class="row">
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('09:30')">09:30</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('10:00')">10:00</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('10:30')">10:30</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('11:00')">11:00</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('13:00')">13:00</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('13:30')">13:30</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('14:00')">14:00</button>
                    </div>
                    <div class="col">
                        <button class="availabilities-slot" onclick="selectTime('14:30')">14:30</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <label for="reason">Reason:</label>
                <textarea class="form-control form-control-lg" id="reason" name="reason" rows="3" required></textarea>
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    function selectTime(time) {
        document.getElementById('selectedTime').value = time;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const appointmentDateInput = document.getElementById('appointmentDate');
        const currentDate = new Date();
        appointmentDateInput.addEventListener('input', function () {
            const selectedDate = new Date(appointmentDateInput.value);
            const dayOfWeek = selectedDate.getDay();
            if (dayOfWeek === 6 || dayOfWeek === 0) {
                alert('Appointments are not available on weekends. Please choose a weekday.');
                appointmentDateInput.value = ''; // Clear the input value
            }
            if (selectedDate < currentDate) {
                alert('Appointments cannot be scheduled for past dates. Please choose a future date.');
                appointmentDateInput.value = ''; // Clear the input value
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const timeSlotButtons = document.querySelectorAll('.availabilities-slot');

        timeSlotButtons.forEach(button => {
            button.addEventListener('click', function () {
                timeSlotButtons.forEach(btn => {
                    btn.style.backgroundColor = '#0d6efd';
                });
                button.style.backgroundColor = '#21ab48';
                const selectedTime = button.innerText;
                document.getElementById('selectedTime').value = selectedTime;
            });
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

