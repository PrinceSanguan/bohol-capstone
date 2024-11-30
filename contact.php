<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('includes/dbconnection.php');
include('admin/inc/essentials.php');
include('admin/inc/functions.php');

// Initialize error message variable
$error_msg = "";

if (isset($_POST['submit'])) {
    // Check if any required fields are empty
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['mobilenumber']) || empty($_POST['message'])) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Sanitize the input data
        $frm_data = filteration($_POST);

        try {
            // Begin a transaction
            $dbh->beginTransaction();
            
            // Prepare the SQL statement with placeholders
            $stmt = $dbh->prepare("INSERT INTO user_queries (name, email, mobilenumber, message) VALUES (?, ?, ?, ?)");
            
            // Execute the statement with actual values
            if ($stmt->execute([$frm_data['name'], $frm_data['email'], $frm_data['mobilenumber'], $frm_data['message']])) {
                echo "<script>alert('Message sent successfully!');</script>";
            } else {
                echo "<script>alert('Failed to send message. Please try again.');</script>";
            }

            // Commit the transaction
            $dbh->commit();
        } catch (PDOException $e) {
            // Roll back the transaction in case of an error
            $dbh->rollBack();
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System | Contact Us Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="images/bnsc123.png" rel="icon">
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
        .iframe-container {
            margin: 20px 0;
            padding: 10px;
            background-color: #f7f7f7;
            border-radius: 5px; /* Optional: adds rounded corners */
            border: 2px solid #007bff; /* Blue border color */
        }
        .custom-alert {
            position: fixed;
            z-index: 100;
            top: 85px;
            right: 25px;
        }
        .centered-text {
            text-align: center;
            font-size: 1.5rem; /* Adjust the size as needed */
            margin: 20px 0;
        }
        .form-container {
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 5px; /* Optional: adds rounded corners */
            border: 2px solid #007bff; /* Blue border color */
            margin-top: 20px; /* Add space between map and form */
            margin-bottom: 20px;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .iframe-container {
                height: auto; /* Adjust height for smaller screens */
            }
            .centered-text {
                font-size: 1.2rem; /* Adjust the size for smaller screens */
            }
        }
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
            background: rgba(0, 0, 0, 0.7);
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
    </style>
</head>
<body>

<?php include_once('includes/header.php');?>

<div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_5.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-8 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Contact</span></p>
                <h1 class="mb-3 bread">Contact Us</h1>
            </div>
        </div>
    </div>
</div>

<section id="contact" class="contact">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="centered-text">Your voice is important to us. Reach out and let’s start a conversation!</div>

        <div class="row gy-4">
            <div class="col-lg-6 col-md-12 iframe-container">
                <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.5496678008813!2d124.46822207592434!3d10.05396959005417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9fe5e86f83223%3A0x680e3637d237f6f5!2sBohol%20Northern%20Star%20Colleges!5e0!3m2!1sfil!2sph!4v1724036565037!5m2!1sfil!2sph" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="col-lg-6 col-md-12 form-container">
                <form action="contact.php" method="post" role="form" class="php-email-form mt-4">
                    <div class="row gy-4">
                        <div class="col-lg-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Fullname:" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email:" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" 
                            placeholder="Mobile No." required 
                            maxlength="11" pattern="\d{11}" title="Please enter an 11-digit mobile number">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message:" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include_once('includes/footer.php');?>

<!-- Load JS libraries -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
