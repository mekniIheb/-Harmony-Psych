    <?php
    session_start();
    // Include your database connection code
    include("connexion.php");

    // Retrieve user details based on the email
    $email = $_SESSION['email'];
    $query = "SELECT * FROM user WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $consultationQuery = "SELECT COUNT(id) AS consultationCount FROM consultation WHERE id_user = :user_id";
    $consultationStatement = $pdo->prepare($consultationQuery);
    $consultationStatement->bindParam(':user_id', $user['id']);
    $consultationStatement->execute();
    $consultationCount = $consultationStatement->fetch(PDO::FETCH_ASSOC)['consultationCount'];
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cabinet Médical</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
              integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/header-auth.css">
        <link rel="stylesheet" href="../../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
    </head>

    <body>
    <style>
        .review {
            font-size: 17px;
            color: var(--light-color);
            margin-left: 20px;
            text-decoration: none;
        }
        .header a {
            font-size: 17px;
            color: var(--light-color);
            margin-left: 20px;
            text-decoration: none;
        }

        .header a:hover {
            color: var(--green);
        }

        .logo-and-menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .action {
            display: flex;
            align-items: center;
        }

        .profile {
            cursor: pointer;
        }

        .menu {
            display: none;
            position: absolute;
            top: 70px;
            right: 0;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .menu.active {
            display: block;
        }

        .menu h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .menu img {
            width: 24px;
            margin-right: 8px;
        }

        @media (max-width: 767px) {
            .header a {
                margin-left: 10px;
            }

            .navbar {
                display: none;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 1rem;
                flex-direction: column;
            }

            .header .animation {
                display: block;
            }

            .header .fas {
                display: block;
                cursor: pointer;
                font-size: 20px;
            }

            .logo-and-menu {
                position: relative;
            }

            .menu-btn {
                display: none;
            }

            .navbar.active {
                display: flex;
            }
        }
    </style>

    <!--header start-->
    <header class="header">
        <div class="logo-and-menu">
            <a href="" class="logo"><i class="fa-solid fa-heart-pulse" style="color: #82E39C;"></i>Harmony Psych.</a>
            <nav class="navbar">
                <div class="action">
                    <div class="profile" onclick="menuToggle()">
                        <img src="../../img/doc.png" alt="Profile Image">
                    </div>
                    <div class="menu">
                        <h3>Hello <?php echo $user['prenom'] . " " . $user['nom'] ?>
                            <br><span><?php echo $user['email'] ?></span></h3>
                        <ul>
                            <li><img src="../../img/img_2.png" alt="Edit Profile Icon"><a href="../user/editProfile.php" >Edit Profile</a></li>
                            <li><img src="../../img/img.png" alt="Logout Icon"><a href="../auth/logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <?php
        // Check the user's role and display menu items accordingly
        if ($user['role'] == 1) {
            echo '<a href="../admin/admin.php">Home</a>';
            echo '<a href="#userTable">User Details</a>';
            echo '<a href="#consultationTable">Consultation Details</a>';
            echo '<a href="#rendezVousTable">Appointment Details</a>';
        } elseif ($user['role'] == 2) {
            echo '<a href="../user/homeUser.php">Home</a>';
            echo '<a href="../user/record.php">Patient Record</a>';
            echo '<a href="../user/appointment.php">Appointment</a>';

            // Disable the "Review" link if consultation count is greater than 0
            if ($consultationCount > 0) {
                echo '<a href="../user/review.php">Review</a>';
            } else {
                echo '<span class="review">Review</span>';
            }
        } else {
            echo '';
        }
        ?>

        <div class="animation"></div>
        <!-- Add this modal structure -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                         <form method="post">
                            <div class="mb-3">
                                <label for="editFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="editFirstName" name="editFirstName" value="<?php echo $user['prenom']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="editLastName" name="editLastName" value="<?php echo $user['nom']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="editEmail" value="<?php echo $user['email']; ?>" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function menuToggle() {
                const toggleMenu = document.querySelector('.menu')
                toggleMenu.classList.toggle('active');
            }
        </script>
    </header>
    </body>
    </html>
