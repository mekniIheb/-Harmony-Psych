<?php
include("../auth/header-auth.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/homeUser.css">
    <link rel="stylesheet" href="../../css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
<div class="container" style="margin-top: 2rem!important;">
    <div id="slide">
        <div class="item"
             style="background-image:url('https://www.voixdespatients.fr/wp-content/uploads/2013/10/schizo1.jpg')
        ">
            <div class="content">
                <div class="name">Schizophrenia</div>
                <div class="des">Schizophrenia affects approximately 24 million people or 1 in 300 people (0.32%)
                    worldwide. This rate is 1 in 222 people (0.45%) among adults (2). It is not as common as many other
                    mental disorders. Onset is most often during late adolescence and the twenties, and onset tends to
                    happen earlier among men than among women.
                </div>
                <button><a target="_blank"
                           href="https://www.who.int/news-room/fact-sheets/detail/schizophrenia">See
                        more</a></button>
            </div>
        </div>
        <div class="item"
             style="background-image: url('https://cdn.who.int/media/images/default-source/mental-health-and-substance-abuse/a-woman-with-a-mask-on-sits-in-a-hospital-setting.tmb-768v.jpg?sfvrsn=b90fbef4_6');">
            <div class="content">
                <div class="name">Anxiety disorders</div>
                <div class="des">People with an anxiety disorder may experience excessive fear or worry about a specific
                    situation (for example, a panic attack or social situation) or, in the case of generalized anxiety
                    disorder, about a broad range of everyday situations. They typically experience these symptoms over
                    an extended period – at least several months. Usually they avoid the situations that make them
                    anxious.
                </div>
                <button><a target="_blank"
                           href="https://www.who.int/news-room/fact-sheets/detail/anxiety-disorders">See more</a>
                </button>
            </div>
        </div>
        <div class="item"
             style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5sQdHknrQSfuBErRRxkDQcKv5wMIyJdP8UQ&usqp=CAU');">
            <div class="content">
                <div class="name">Mental disorders</div>
                <div class="des">A mental disorder is characterized by a clinically significant disturbance in an
                    individual’s cognition, emotional regulation, or behaviour. It is usually associated with distress
                    or impairment in important areas of functioning.
                </div>
                <button><a target="_blank" href="https://www.who.int/news-room/fact-sheets/detail/mental-disorders">See
                        more</a></button>
            </div>
        </div>
        <div class="item"
             style="background-image: url('https://img.passeportsante.net/1200x675/2021-02-01/i99434-.webp');">
            <div class="content">
                <div class="name">Post-traumatic disorders.</div>
                <div class="des">Posttraumatic stress disorder (PTSD) is a psychiatric disorder that may occur in people
                    who have experienced or witnessed a traumatic event, series of events or set of circumstances.
                </div>
                <button><a target="_blank" href="https://www.psychiatry.org/patients-families/ptsd/what-is-ptsd">See
                        more</a></button>
            </div>
        </div>

    </div>
    <div class="buttons">
        <button id="prev"><i class="fa-solid fa-angle-left"></i></button>
        <button id="next"><i class="fa-solid fa-angle-right"></i></button>
    </div>
</div>
<script>
    document.getElementById('next').onclick = function () {
        let lists = document.querySelectorAll('.item');
        document.getElementById('slide').appendChild(lists[0]);
    }
    document.getElementById('prev').onclick = function () {
        let lists = document.querySelectorAll('.item');
        document.getElementById('slide').prepend(lists[lists.length - 1]);
    }

</script>
<!--footer start-->
<?php
include("../auth/footer.php");
?>
<!--footer  end-->
</body>
</html>
