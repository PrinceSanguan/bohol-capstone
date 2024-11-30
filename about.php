<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System | About Us Page</title>
        <!-- Favicon and Fonts -->
    <link href="images/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="images/logosas.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .hero-wrap {
            height: 100vh;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            background-repeat: no-repeat;
        }

        .hero-wrap .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7 );
        }

        .img-about {
            background-size: cover;
            background-position: center;
            height: 100%;
            max-height: 400px;
        }

        @media (max-width: 768px) {
            .hero-wrap {
                height: 60vh;
            }
            .img-about {
                max-height: 250px;
            }
        }

        @media (max-width: 576px) {
            .hero-wrap {
                height: 50vh;
            }
            .img-about {
                max-height: 200px;
            }
        }
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    color: #333;
}

/* Section Styles */
.content-section {
    display: flex;
    justify-content: center;
    padding: 40px 0;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeIn 1.5s ease-out forwards;
    position: relative;
}

.center {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    width: 100%;
    padding: 20px;
}

.image-container img {
    max-width: 400px;
    height: auto;
    border-radius: 8px;
}

.text-container {
    max-width: 600px;
    background-color: #f5f5f5;
    padding: 15px;
    border-radius: 8px;
}

.text-container h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

.text-container p {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 15px;
    color: #666;
}

/* Animation */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Positioning */
.image-container.left {
    order: 1;
}

.text-container.right {
    order: 2;
}

.text-container.left {
    order: 1;
}

.image-container.right {
    order: 2;
}

/* Responsive Design */
@media (max-width: 768px) {
    .center {
        flex-direction: column;
    }

    .image-container, .text-container {
        order: 0;
        max-width: 100%;
        text-align: center;
    }

    .image-container img {
        max-width: 100%;
        margin-bottom: 20px;
    }
}

    </style>
</head>
<body>

<?php include_once('includes/header.php');?>

<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_5.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-8 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>About</span></p>
                <h1 class="mb-3 bread">About</h1>
            </div>
        </div>
    </div>
</div>


<section class="content-section fade-in">
        <div class="center">
            <div class="image-container left">
                <img src="images/stu.jpg" alt="Image 1">
            </div>
            <div class="text-container right">
                <p><b>At Bohol Northern Star College,</b> we are committed to identifying and nurturing the unique potential of each student. We understand that every learner brings their own strengths and aspirations, and our goal is to support their journey toward personal and academic excellence.</p>
            </div>
        </div>
    </section>

    <section class="content-section fade-in">
        <div class="center">
            <div class="text-container left">
                <p><b>Through our scholarship program,</b> we provide financial assistance to students who show a commitment to their education and demonstrate outstanding potential. These scholarships are more than just awards; they are an investment in a student’s future and a way to reduce the financial barriers that may stand in the way of their dreams.</p>
            </div>
            <div class="image-container right">
                <img src="images/stu1.jpg" alt="Image 2">
            </div>
        </div>
    </section>

    <section class="content-section fade-in">
        <div class="center">
            <div class="image-container left">
                <img src="images/stu3.jpg" alt="Image 3">
            </div>
            <div class="text-container right">
                <p><b>By empowering our students</b> with the resources and opportunities they need, we hope to see them flourish and contribute meaningfully to their communities. Bohol Northern Star College believes that each student’s success not only transforms their own lives but also enriches the world around them.</p>
            </div>
        </div>
    </section>
<?php include_once('includes/footer.php');?>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>

</body>
</html>
