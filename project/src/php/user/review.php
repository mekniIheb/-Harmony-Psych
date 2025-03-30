<?php
include("../auth/header-auth.php");
session_start();

/* if (!isAuthenticatedUser()) {
    header("Location: ../auth/login.php");
    exit();
} */

$email = $_SESSION['email'];
$query = "SELECT * FROM user WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->bindParam(':email', $email);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $reviewMessage = isset($_POST['reviewMessage']) ? htmlspecialchars(trim($_POST['reviewMessage'])) : '';

    // Validate the rating (you can add more validation if needed)
    if ($rating < 1 || $rating > 5) {
        echo "<script>alert('Invalid rating.');</script>";
    } else {
        // Insert data into the "reviews" table
        $insertQuery = "INSERT INTO reviews (user_id, rating, review_message) VALUES (:user_id, :rating, :reviewMessage)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
        $insertStatement->bindParam(':rating', $rating, PDO::PARAM_INT);
        $insertStatement->bindParam(':reviewMessage', $reviewMessage, PDO::PARAM_STR);

        if ($insertStatement->execute()) {
            echo "<script>alert('Review submitted successfully.');</script>";
        } else {
            echo "<script>alert('Error: Unable to submit review.');</script>";
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
    <link rel="stylesheet" href="../../css/review.css">
</head>
<body>

<div class="review-container">
    <h2 style="text-align: center;">Leave a Review</h2>

    <form method="post" action="">
        <div class="rating-container">
            <span class="rating-stars" onclick="setRating(1)">&#9733;</span>
            <span class="rating-stars" onclick="setRating(2)">&#9733;</span>
            <span class="rating-stars" onclick="setRating(3)">&#9733;</span>
            <span class="rating-stars" onclick="setRating(4)">&#9733;</span>
            <span class="rating-stars" onclick="setRating(5)">&#9733;</span>
            <input type="hidden" name="rating" id="rating" value="1">
        </div>

        <div class="form-group">
            <label for="reviewMessage" style="font-size: larger;">Your Review:</label>
            <textarea class="form-control" id="reviewMessage" name="reviewMessage" rows="5"></textarea>
        </div>

        <div class="row mt-4 right-buttons">
            <div class="col"></div>
            <div class="col">
                <button type="submit" class="button-34" role="button" style="background: #8c82fb;">Submit Review</button>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
    let selectedRating = 0;

    function setRating(rating) {
        selectedRating = rating;
        highlightStars(rating);
        document.getElementById('rating').value = rating;
    }

    function highlightStars(count) {
        const stars = document.querySelectorAll('.rating-stars');
        stars.forEach((star, index) => {
            if (index < count) {
                star.style.color = '#ff9700';
            } else {
                star.style.color = '#f5ce63';
            }
        });
    }

    $(document).ready(function () {
        $('#star-rating .fa').on('click', function () {
            const rating = $(this).data('rating');
            $('#rating').val(rating);
            $(this).addClass('checked').prevAll().addClass('checked');
            $(this).nextAll().removeClass('checked');
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
