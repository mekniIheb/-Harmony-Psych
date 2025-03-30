<?php
session_start();
include("../auth/auth.php"); // Adjust the path as needed

if (!isAuthenticatedAdmin()) {
    header("Location: ../auth/login.php"); // Redirect to the login page if not authenticated
    exit();
}
include("../auth/connexion.php"); // Include your database connection file

$queryUsers = "SELECT COUNT(*) as total_users FROM user where role != 1";
$statementUsers = $pdo->prepare($queryUsers);
$statementUsers->execute();
$usersData = $statementUsers->fetch(PDO::FETCH_ASSOC);

// -------------------
$queryPositiveReviews = "SELECT COUNT(*) as positive_reviews FROM reviews WHERE rating >= 3";
$statementPositiveReviews = $pdo->prepare($queryPositiveReviews);
$statementPositiveReviews->execute();
$positiveReviewsData = $statementPositiveReviews->fetch(PDO::FETCH_ASSOC);
//---------------
$queryRendezVous = "SELECT COUNT(*) as total_rendezvous FROM rendezvous";
$statementRendezVous = $pdo->prepare($queryRendezVous);
$statementRendezVous->execute();
$rendezvousData = $statementRendezVous->fetch(PDO::FETCH_ASSOC);
//------------
$queryRecord = "SELECT COUNT(*) as total_records FROM consultation";
$statementRecord = $pdo->prepare($queryRecord);
$statementRecord->execute();
$recordData = $statementRecord->fetch(PDO::FETCH_ASSOC);
//get users
$queryUsers = "SELECT u.id, u.prenom, u.nom, u.email, r.nom as role_name
               FROM user u
               JOIN role r ON u.role = r.id";
$statementUser = $pdo->prepare($queryUsers);
$statementUser->execute();
$userData = $statementUser->fetchAll(PDO::FETCH_ASSOC);
//-----------
$queryConsultation = "SELECT * FROM consultation";
$statementConsultation = $pdo->prepare($queryConsultation);
$statementConsultation->execute();
$consultationData = $statementConsultation->fetchAll(PDO::FETCH_ASSOC);
//-----------
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $deleteQuery = "DELETE FROM user WHERE id = :id";
    $deleteStatement = $pdo->prepare($deleteQuery);
    $deleteStatement->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($deleteStatement->execute()) {
        echo "User deleted successfully!";
    } else {
        echo "Error: Unable to delete user.";
    }
} else {
    echo "Error: User ID not provided.";
}
//----------
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Update the user's role to 1 (assuming 1 represents the 'admin' role)
    $updateQuery = "UPDATE user SET role = 1 WHERE id = :id";
    $updateStatement = $pdo->prepare($updateQuery);
    $updateStatement->bindParam(':id', $userId, PDO::PARAM_INT);

    $response = array();

    if ($updateStatement->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    echo json_encode($response);
} else {
    echo json_encode(array('success' => false));
}
//----------
$query = "SELECT * FROM rendezvous WHERE appointmentDate >= CURDATE() ORDER BY appointmentDate";
$statement = $pdo->prepare($query);
$statement->execute();

$rendezVousData = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <!-- Include jQuery and Bootstrap 4 CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Include Bootstrap 4 JS and Bootstrap 5 CSS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Include DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

</head>
<body>
<?php
include("../auth/header-auth.php");
?>

<div class="container-fluid" style="padding-top: 10em">
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers"> <?php echo $usersData['total_users']; ?></div>
                <div class="cardName">Users</div>
            </div>

            <div class="iconBx">
                <i class="fa-solid fa-user"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $recordData['total_records']; ?></div>
                <div class="cardName">Patient Record</div>
            </div>

            <div class="iconBx">
                <i class="fa-solid fa-people-arrows"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $rendezvousData['total_rendezvous']; ?></div>
                <div class="cardName">Appointments</div>
            </div>

            <div class="iconBx">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $positiveReviewsData['positive_reviews']; ?></div>
                <div class="cardName">Positive Reviews</div>
            </div>

            <div class="iconBx">
                <i class="fa-solid fa-star"></i>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h2>User Details</h2>
        <table id="userTable" class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($userData as $user) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['prenom']; ?></td>
                    <td><?php echo $user['nom']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role_name']; ?></td>
                    <td>
                        <?php if ($user['role_name'] != 'admin') : ?>
                            <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                                    onclick="confirmDelete(<?php echo $user['id']; ?>)"><i
                                    class="fa-solid fa-trash"></i></button>
                            <button class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                    title="Change To Admin" onclick="confirmChangeToAdmin(<?php echo $user['id']; ?>)">
                                <i class="fa-solid fa-user-tie"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row">
        <h2>Consultation details</h2>
        <table class="table table-striped" id="consultationTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Birthday</th>
                <th>Patient Gender</th>
                <th>Blood Group</th>
                <th>Phone Number</th>
                <th>Assurance Number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($consultationData as $consultation) : ?>
                <tr>
                    <td><?php echo $consultation['id']; ?></td>
                    <td><?php echo $consultation['firstName']; ?></td>
                    <td><?php echo $consultation['lastName']; ?></td>
                    <td><?php echo $consultation['email']; ?></td>
                    <td><?php echo $consultation['birthday']; ?></td>
                    <td><?php echo $consultation['patientGender']; ?></td>
                    <td><?php echo $consultation['bloodGroup']; ?></td>
                    <td><?php echo $consultation['phoneNumber']; ?></td>
                    <td><?php echo $consultation['assuranceNumber']; ?></td>
                    <td>
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                title="Details" onclick="navigateToDetails(<?php echo $consultation['id']; ?>)" >
                            <i class="fa-solid fa-circle-info"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row">
        <h2>Appointment details</h2>
        <table class="table table-striped" id="rendezVousTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Appointment Date</th>
                <th>Raison</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rendezVousData as $rendezVous) : ?>
                <tr>
                    <td><?php echo $rendezVous['id']; ?></td>
                    <td><?php echo $rendezVous['firstName'] ." ".$rendezVous['lastName']; ?></td>
                    <td><?php echo $rendezVous['phoneNumber']; ?></td>
                    <td><?php echo $rendezVous['appointmentDate']."/".$rendezVous['selectedTime'] ?></td>
                    <td><?php echo $rendezVous['reason']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#userTable').DataTable();
    });
    $(document).ready(function () {
        $('#consultationTable').DataTable();
    });
    $(document).ready(function () {
        $('#rendezVousTable').DataTable();
    });
    function navigateToDetails(consultationId) {
        // Redirect to detailsConsultation.php with the consultation ID
        window.location.href = "detailsConsultation.php?id=" + consultationId;
    }
    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "admin.php?id=" + userId;
        }
    }

    function confirmChangeToAdmin(userId) {
        if (confirm("Are you sure you want to change this user's role to Admin?")) {
            // If the user clicks "OK," make an AJAX request to update the user's role
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "admin.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response as needed (you can show an alert or update the UI)
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("User role updated successfully!");
                        location.reload();
                    } else {
                        alert("Error updating user role.");
                    }
                }
            };
            xhr.send("id=" + userId);
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
