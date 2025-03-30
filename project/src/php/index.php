<?php
include("auth/connexion.php");

function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $phone = sanitizeInput($_POST['phone']);
    $email = sanitizeInput($_POST['email']);
    $message = sanitizeInput($_POST['message']);

    if (empty($firstname)) {
        $errors['firstname'] = "Please enter your firstname";
    }

    if (empty($lastname)) {
        $errors['lastname'] = "Please enter your lastname";
    }

    if (empty($phone)) {
        $errors['phone'] = "Please enter your phone number";
    } elseif (!preg_match("/^\d{10}$/", $phone)) {
        $errors['phone'] = "Please enter a valid 10-digit phone number";
    }

    if (empty($email)) {
        $errors['email'] = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address";
    }

    if (empty($message)) {
        $errors['message'] = "Please enter your message";
    }

    if (empty($errors)) {
        $query = "INSERT INTO contact (firstname, lastname, phone, email, message) 
                  VALUES (:firstname, :lastname, :phone, :email, :message)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':firstname', $firstname);
        $statement->bindParam(':lastname', $lastname);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':message', $message);

        if ($statement->execute()) {
            echo "<script>alert('Message sent successfully.');</script>";
        } else {
            echo "<script>alert('Error sending message. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
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
    <?php
    include("auth/header.php");
    ?>
 <!--header end-->  
 
 
 <!--section start-->  
    <section class="home" id="home">
        <div class="image">
            <img src="../img/undraw_doctors_p6aq.svg" alt="" width="400px">
        </div>
        <div class="content">
            <h3>Stay safe,stay healthy</h3>
            <p>mental health is not a distination,but a process.It's about how you drive,not where you're going</p>
            <a href="auth/login.php" class="btn" target="_blank">Log in<span class="fa-solid fa-user"></span></a>
            
        </div>
    </section>

 <!--section end-->    

 <!-- icons start-->   
    <div class="icons-container">
        <div class="icon num" >
            <i class="fa-solid fa-user-check"></i>
           
            <p>Appointment today</p>
            <h3>0</h3>
        </div>
        <div class="icon">
            <i class="fa-solid fa-user-minus"></i>
            
            <p>Critical stocks</p>
            <h3>1</h3>
        </div>
        <div class="icon">
            <i class="fa-solid fa-users"></i>
           
            <p>Total patients</p>
            <h3>17</h3>
        </div>
    </div>
 
 <!--icons end-->    


 <!--about start-->
 <section class="about" id="about">
    <div class="row">
        <div class="col">
            <img src="../img/doctor.jpg" alt="Doctor's photo" class="doctor">
        </div>
        <div class="col">
            <div class="text">
                <h2>About Dr. Aymen Bensalem</h2>
                <table>
                    <tr>
                        <td class="td1">Doctor's name:</td>
                        <td>Aymen Bensalem</td>
                    </tr>
                    <tr>
                        <td class="td1">Medical speciality:</td>
                        <td>General Psychiatrist</td>
                    </tr>
                    <tr>
                        <td class="td1">Doctor's office address:</td>
                        <td>Lac de Tunis</td>
                    </tr>
                    <tr>
                        <td class="td1">Education:</td>
                        <td>Doctorat en médecine, Université de la Santé, Tunis, 2015</td>
                    </tr>
                    <tr>
                        <td class="td1">Certifications:</td>
                        <td>Certifié par le Conseil de Psychiatrie</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Membre de l'Association Psychiatrique Nationale</td>
                    </tr>
                </table>
                <a href="#" class="btn">Learn More <span class="fas fa-chevron-right"></span></a>
            </div>
        </div>
    </div>
</section>

 <!--about end--> 

 

 <!--review end--> 
<section class="review" id="review">
    <div class="heading">
        <h1 class="heading">clients's <span class="reviex">review</span></h1>
    </div>
    <div class="box-container">
        <div class="box">
            <img src="../img/christian-buehner-DItYlc26zVI-unsplash.jpg" alt="" width="100px" width="100px">
            <h3>john doe</h3>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            
            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Odit aspernatur a deleniti id? Distinctio consectetur illum, 
                itaque iste unde, sunt ipsam cupiditate asperiores dolorum excepturi debitis hic laudantium pariatur et.
            </p>
        </div>
        <div class="box">
            <img src="../img/lashawn-dobbs-wOe_VGJe3TE-unsplash.jpg" alt="" width="100px" width="100px">
            <h3>allona smith</h3>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <p class="text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Odit aspernatur a deleniti id? Distinctio consectetur illum, 
                itaque iste unde, sunt ipsam cupiditate asperiores dolorum excepturi debitis hic laudantium pariatur et.
            </p>
        </div>
    </div>
</section>

  <!--review end--> 

 <!--contact start-->
<section class="book" id="contact Us">
    <div class="row">
        <div class="col">
            <div class="row">
                <form id="contactForm" method="post" action="">
                    <h3>Message us</h3>

                    <input type="text" id="firstname" name="firstname" placeholder="Enter your firstname" class="box">
                    <span class="error" id="firstnameError"></span>

                    <input type="text" id="lastname" name="lastname" placeholder="Enter your lastname" class="box">
                    <span class="error" id="lastnameError"></span>

                    <input type="text" id="phone" name="phone" placeholder="Enter your Phone number" class="box">
                    <span class="error" id="phoneError"></span>

                    <input type="email" id="email" name="email" placeholder="Enter your email" class="box">
                    <span class="error" id="emailError"></span>

                    <textarea id="message" name="message" cols="20" rows="9" placeholder="Write your message here..." class="box"></textarea>
                    <span class="error" id="messageError"></span>

                    <input type="submit" value="Send" class="btn" onclick="validateForm(event)">
                </form>
            </div>
        </div>
        <div class="col">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51102.30398436679!2d10.210677750506708!3d36.821059924051035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd357ac435ae01%3A0x8009d1c72632d566!2sLac%20de%20Tunis!5e0!3m2!1sfr!2stn!4v1700242122284!5m2!1sfr!2stn" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

  <!--contact end-->


  <!--footer starts-->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>--quick links</h3>
                <a href="#home"><i class="fas fa-chevron-right"></i>home</a>
                <a href="#about"><i class="fas fa-chevron-right"></i>about</a>
                <a href="#book"><i class="fas fa-chevron-right"></i>book</a>
                <a href="#contact us"><i class="fas fa-chevron-right"></i>contact us</a>
                <a href="#review"><i class="fas fa-chevron-right"></i>review</a>
                <a href="#log in"><i class="fas fa-chevron-right"></i>log in</a>
            </div>
            <div class="box">
                <h3>contact info</h3>
                <a href="#"><i class="fas fa-phone"></i>+216-53-587-369</a>
                <a href="#"><i class="fas fa-envelope"></i>aymenbensalem@gmail.com</a>
                <a href="#"><i class="fas fa-map-marker-alt"></i>lac,Tunis</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#"><i class="fa-brands fa-twitter"></i>twitter</a>
                <a href="#"><i class="fa-brands fa-facebook"></i>facebook</a>
                <a href="#"><i class="fa-brands fa-instagram"></i>instagram</a>
                <a href="#"><i class="fa-brands fa-linkedin"></i>linkedin</a>
            </div>
        </div>
        <div class="credit">created by <span>Maha Krimi </span> | all rights reserved</div>
    </section>



  <!--footer end-->



<script>
    function validateForm(event) {
        event.preventDefault();

        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var phone = document.getElementById('phone').value;
        var email = document.getElementById('email').value;
        var message = document.getElementById('message').value;

        var firstnameError = document.getElementById('firstnameError');
        var lastnameError = document.getElementById('lastnameError');
        var phoneError = document.getElementById('phoneError');
        var emailError = document.getElementById('emailError');
        var messageError = document.getElementById('messageError');

        // Reset previous errors
        firstnameError.textContent = '';
        lastnameError.textContent = '';
        phoneError.textContent = '';
        emailError.textContent = '';
        messageError.textContent = '';

        var isValid = true;

        if (firstname.trim() === '') {
            firstnameError.textContent = 'Please enter your firstname';
            isValid = false;
        }

        if (lastname.trim() === '') {
            lastnameError.textContent = 'Please enter your lastname';
            isValid = false;
        }

        if (phone.trim() === '') {
            phoneError.textContent = 'Please enter your phone number';
            isValid = false;
        } else if (!/^\d{10}$/.test(phone)) {
            phoneError.textContent = 'Please enter a valid 10-digit phone number';
            isValid = false;
        }

        if (email.trim() === '') {
            emailError.textContent = 'Please enter your email';
            isValid = false;
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
            emailError.textContent = 'Please enter a valid email address';
            isValid = false;
        }

        if (message.trim() === '') {
            messageError.textContent = 'Please enter your message';
            isValid = false;
        }

        if (isValid) {
            // If the form is valid, you can submit the form here
            document.getElementById('contactForm').submit();
        } else {
            // If the form is not valid, you can display a custom alert or take other actions
            showCustomAlert('Please fix the errors and try again.');
        }
    }

    function showCustomAlert(message) {
        alert(message);
        // You can customize this function to show your custom alert
        // For example, you can use a modal or a custom-styled div to display the message
    }
</script>
</body>
</html>
