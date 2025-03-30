<?php
include("../auth/header-auth.php");

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}
include("../auth/connexion.php"); // Include your database connection file

// Ensure that the consultation ID is provided in the URL
if (isset($_GET['id'])) {
    $consultationId = $_GET['id'];

// Fetch consultation details based on the provided ID
    $queryConsultationDetails = "SELECT * FROM consultation WHERE id = :id";
    $statementConsultationDetails = $pdo->prepare($queryConsultationDetails);
    $statementConsultationDetails->bindParam(':id', $consultationId, PDO::PARAM_INT);
    $statementConsultationDetails->execute();
    $consultationDetails = $statementConsultationDetails->fetch(PDO::FETCH_ASSOC);

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
    span {
        font-size: larger;
    }

    a.btn.btn-secondary {
        width: 5em;
    }
</style>
<div class="container mt-5" style="margin-top: 9rem!important;">
    <a class="btn btn-secondary" href="javascript:history.back()" data-toggle="tooltip" data-placement="top"
       title="Back"><i class="fa-solid fa-backward"></i></a>
    <div class="center-title">
        <h2 class="mb-4">Patient Record </h2>
    </div>
    <hr>

    <!-- Partie 1: Information Patient -->
    <form id="registrationForm" method="post" action="#">
        <div class="row">
            <div class="col-md-4">
                <h3><span> <img src="../../img/user-icon-2048x2048-ihoxz4vq.png" width="30"></span>Patient Information
                </h3>

                <div class="form-group">
                    <label for="lastName">Last Name:<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['lastName']; ?></span>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <span><?php echo $consultationDetails['firstName']; ?></span>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['birthday']; ?></span>
                </div>
                <div class="form-group">
                    <label for="patientGender">Patient Gender:<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['patientGender']; ?></span>
                </div>
                <div class="form-group">
                    <label for="bloodGroup">Blood Group:<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['bloodGroup']; ?></span>
                </div>
                <div class="form-group">
                    <label for="familySituation">Family Situation :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['familySituation']; ?></span>
                </div>
                <div class="form-group">
                    <label for="profession">Profession :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['profession']; ?></span>
                </div>
            </div>
            <div class="col-md-4">
                <h3><span> <img src="../../img/phone.png" width="30"></span>Patient Contact Information</h3>
                <div class="form-group">
                    <label for="email">Email:<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['email']; ?></span>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['phoneNumber']; ?></span>
                </div>
                <div class="form-group">
                    <label for="phoneNumber2">Phone Number 2:</label>
                    <span><?php echo $consultationDetails['phoneNumber2']; ?></span>
                </div>
                <div class="form-group">
                    <label for="assuranceNumber">Assurance Number :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['assuranceNumber']; ?></span>

                </div>
                <div class="form-group">
                    <label for="address">Address :<span class="text-danger">*</span></label>
                    <span><?php echo $consultationDetails['address']; ?></span>
                </div>
                <div class="form-group">
                    <label for="note">Note :</label>
                    <span><?php echo $consultationDetails['note']; ?></span>
                </div>
            </div>
            <div class="col-md-4">
                <h3><span> <img src="../../img/antecedents.png" width="30"></span>Background</h3>
                <div class="form-group">
                    <label for="medicalHistory">Medical History :</label>
                    <span><?php echo $consultationDetails['medicalHistory']; ?></span>
                </div>
                <div class="form-group">
                    <label for="surgicalHistory">Surgical History:</label>
                    <span><?php echo $consultationDetails['surgicalHistory']; ?></span>
                </div>
                <div class="form-group">
                    <label for="familyHistory">familyHistory:</label>
                    <span><?php echo $consultationDetails['familyHistory']; ?></span>
                </div>
                <div class="form-group">
                    <label for="otherHistory">Other History:</label>
                    <span><?php echo $consultationDetails['otherHistory']; ?></span>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Custom JavaScript for form validation -->
<!--footer start-->
<?php
include("../auth/footer.php");
?>
<!--footer  end-->
</body>
</html>
