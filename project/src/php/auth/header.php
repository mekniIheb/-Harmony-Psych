<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical</title>
    <link rel="stylesheet   " href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>

        .error {
            color: red;
        }

        .box.error {
            border: 1px solid red;
        }
    </style>

</head>

<body>
<!--header start-->
    <header class="header">
        <a href="" class="logo"><i class="fa-solid fa-heart-pulse" style="color:  #82E39C;"></i>Harmony Psych.</a>
        <nav class="navbar">
            <?php
            if(isset($_SESSION['admin'])){
                $user = $_SESSION['admin'];
                echo '
                <a href="#">'.$user. '</a>
                <a href="auth/logout.php">Logout</a>';
            } else {
                echo '
                <a href="auth/login.php">Login</a>
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#contact Us">Contact us</a>
                <a href="#review">Review</a>';
            }


            ?>

        </div>

        </nav>
        <div id="menu-btn" class="fas fa-bars">

        </div>
    </header>

    <script src="../../js/script.js"></script>
</body>
</html>
