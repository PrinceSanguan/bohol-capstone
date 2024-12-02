<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System | Scholarship Page</title>

    <!-- Bootstrap CSS for responsive layout -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
    
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

    <!-- Custom Responsive Styles -->
    <style>
          .hero-wrap {
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
       
        .course {
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .course:hover {
            transform: scale(1.05);
        }

        .course .img {
            background-size: contain; /* Adjusted for logo */
            background-position: center;
            height: 300px;
        }



        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem; /* Space between items */
        }

        .form-item {
            flex: 1 1 calc(30% - 1rem); /* Adjust based on desired width */
            min-width: 250px; /* Minimum width for small screens */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }
        
    </style>
</head>
<body>

    <!-- Include Header -->
    <?php include_once('includes/header.php');?>

     <!-- Hero Section with Responsive Background -->
     <div class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_5.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no -gutters slider-text align-items-center justify-content-center">
                <div class="col-md-8 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Scholarships</span></p>
                    <h1 class="mb-3 bread">Scholarships</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="ftco-section">
        <div class="container">
        <div class="form-container">
    <?php
    $sql = "SELECT * from tblscheme";
    $query = $dbh -> prepare($sql);
    $query -> execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        foreach($results as $row) { ?>
            <div class="form-item">
                <div class="course align-self-stretch">
                    <a href="#" class="img" style="background-image: url('<?php echo $row->Image; ?>');"></a> <!-- Use the dynamic image -->
                    <div class="text p-4">
                        <h3 class="mb-3"><?php echo $row->SchemeName; ?></h3>
                        <p>
                            
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $row->ID;?>">View Details</button>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal for Viewing Details -->
            <div class="modal fade" id="detailsModal<?php echo $row->ID;?>" tabindex="-1" aria-labelledby="detailsModalLabel<?php echo $row->ID;?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel<?php echo $row->ID;?>">Details for: <?php echo $row->SchemeName; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p><strong>Scholarship Tuition Fee:</strong> <?php echo $row->Scholarfee; ?></p>
                        <p><strong>Requirements for Scholarship:</strong> <?php echo $row->Requirements; ?></p>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }
    ?>
</div>

        </div>
    </section>

    <!-- Include Footer -->
    <?php include_once('includes/footer.php');?>
    <!-- Include Footer -->


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