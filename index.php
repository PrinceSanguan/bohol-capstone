<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>

    <title>Scholarship Management System | Index Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="images/logosas.png" rel="icon">

    <!-- Importing Lato Font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
    <link href="images/bnsc123.png" rel="icon">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Custom CSS for background switcher and button styling -->
    <style>
        body {
            font-family: 'Lato', sans-serif; /* Set the default font for the entire page */
        }

        .hero {
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: background-image 1s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center; /* Center text inside hero */
            padding: 0 20px; /* Add padding for smaller screens */
        }

        /* Overlay covering the entire hero section */
        .overlay {
            position: absolute; /* Position absolute to fill the entire hero section */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black */
            z-index: 1; /* Place it behind text and buttons */
        }

        /* Text Container */
        .text-container {
            position: relative; /* Position relative to overlay */
            z-index: 2; /* Ensure text is above the overlay */
            max-width: 600px; /* Limit width for better readability */
            margin-bottom: 20px; /* Space below the overlay */
            padding: 20px; /* Padding around the text */
            text-align: center; /* Center text */
        }

        /* Scholarship text styling */
        .hero .scholarship-text {
            color: #fff; /* White text for visibility */
            font-size: 30px; /* Set font size to 30px */
            font-weight: bold; /* Bold font for emphasis */
            line-height: 1.5; /* Improved line height for readability */
        }

        /* Ensure the button container is centered */
        .hero .btn-container {
            z-index: 2; /* Ensure the buttons are above the background */
            margin-bottom: 20px; /* Space below the buttons */
        }

        /* Button Styling */
        .hero .btn {
            margin: 10px; /* Uniform margin for buttons */
            padding: 15px 30px;
            font-size: 18px;
            transition: background-color 0.3s; /* Add transition effect */
        }

        .hero .btn:hover {
            background-color: #0056b3; /* Darker shade on hover for primary button */
        }

        /* Responsive Hero Section */
        @media (max-width: 768px) {
            .hero {
                height: 60vh;
            }

            .hero .btn {
                font-size: 16px;
                padding: 12px 24px; /* Smaller padding for buttons */
            }

            .hero .scholarship-text {
                font-size: 28px; /* Slightly smaller font size for scholarship text on medium screens */
            }
        }

        @media (max-width: 576px) {
            .hero {
                height: 50vh;
            }

            .hero .btn {
                font-size: 14px;
                padding: 10px 20px; /* Smaller padding for buttons */
            }

            .hero .scholarship-text {
                font-size: 24px; /* Smaller font size for scholarship text on small screens */
            }
        }
    </style>

    <!-- JavaScript for background switching -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var backgroundImages = [
                'images/hero-carousel/b1.jpg',
                'images/hero-carousel/bg_5.jpg',
                'images/hero-carousel/b5.jpg',
                'images/hero-carousel/b7.jpg'
            ];
            var heroSection = document.querySelector('.hero');
            var currentIndex = 0;

            function updateBackground() {
                heroSection.style.backgroundImage = 'url(' + backgroundImages[currentIndex] + ')';
            }

            setInterval(function() {
                currentIndex = (currentIndex + 1) % backgroundImages.length;
                updateBackground();
            }, 3000); // Switch background every 3 seconds
        });
    </script>
</head>

<body>
    
    <?php include_once('includes/header.php');?>

    <!-- Hero Section -->
    <section id="hero" class="hero" style="background-image: url('images/hero-carousel/stu.jpg');">
        <div class="overlay"></div> <!-- Overlay div for black background -->
        <div class="text-container"> <!-- Text container for scholarship message -->
            <div class="scholarship-text">
                Discover opportunities for your future with our scholarship programs designed to help you succeed in your education and career.
            </div>
        </div>
        <div class="btn-container">
            <a href="users/login.php" class="btn btn-primary">Apply Now</a>
            <a href="schemes.php" class="btn btn-secondary">View Scholarships</a>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
