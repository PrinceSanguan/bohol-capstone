<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Session check: if not logged in, redirect to the login page
if (strlen($_SESSION['uid']) == 0) {
  header('location:logout.php');
} else {
  $img = $_SESSION['img']; // Image from the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scholarship Management System || Dashboard</title>
  <?php include('inc/links.php'); ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../assets/css/pace.min.css" rel="stylesheet"/>
  <script src="../assets/js/pace.min.js"></script>
  <!--favicon-->
  <link href="image/bnsc123.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
  <!-- Vector CSS -->
  <link href="../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
  <!-- simplebar CSS-->
  <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="../assets/css/app-style.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    .dashboard-card {
      background-color: #282c34;
      color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .dashboard-card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .dashboard-card h5 {
      font-size: 22px;
      font-weight: bold;
    }

    .dashboard-card .progress {
      height: 5px;
      background-color: #444;
    }

    .dashboard-card .progress-bar {
      background-color: #17a2b8;
    }

    .card-link {
      color: #17a2b8;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
    }

    .card-link:hover {
      text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .dashboard-card h5 {
        font-size: 18px;
      }
      .dashboard-title {
        font-size: 24px;
        text-align: center;
      }
    }

    @media (max-width: 576px) {
      .dashboard-title {
        font-size: 20px;
      }
      .dashboard-card {
        padding: 15px;
      }
    }
  </style>
</head>

<body class="bg-theme bg-theme9">
  <!-- Start wrapper -->
  <div id="wrapper">
    <!-- Start sidebar-wrapper -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- End sidebar-wrapper -->

    <!-- Start topbar header -->
    <?php include_once('includes/header.php'); ?>
    <!-- End topbar header -->

    <div class="clearfix"></div>

    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Start Dashboard Content -->
        <h4 class="dashboard-title">Dashboard</h4>
    <div class="card-content">
        <div class="row">
            <!-- Approved Scholarships -->
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card-body dashboard-card border-light">
                    <?php
                        $uid = $_SESSION['uid'];
                        $sql = "SELECT * FROM tblapply WHERE Status='Approved' && UserID = :uid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                        $query->execute();
                        $approvedapp = $query->rowCount();
                    ?>
                    <h5 class="text-white mb-0"><?php echo htmlentities($approvedapp); ?>
                        <span class="float-right">Approved Scholarships</span>
                    </h5>
                    <div class="progress my-3" style="height: 3px;">
                        <div class="progress-bar" style="width: 55%"></div>
                    </div>
                    <a href="approved-application.php">
                        <p class="mb-0 text-white small-font">View Details <span class="float-right">
                            <i class="fa fa-arrow-right"></i></span></p>
                    </a>
                </div>
            </div>

            <!-- Rejected Scholarships -->
            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card-body dashboard-card border-light">
                    <?php
                        $sql = "SELECT * FROM tblapply WHERE Status='Rejected' && UserID = :uid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                        $query->execute();
                        $rejectedapp = $query->rowCount();
                    ?>
                    <h5 class="text-white mb-0"><?php echo htmlentities($rejectedapp); ?>
                        <span class="float-right">Rejected Scholarships</span>
                    </h5>
                    <div class="progress my-3" style="height: 3px;">
                        <div class="progress-bar" style="width: 55%"></div>
                    </div>
                    <a href="rejected-application.php">
                        <p class="mb-0 text-white small-font">View Details <span class="float-right">
                            <i class="fa fa-arrow-right"></i></span></p>
                    </a>
                </div>
            </div>

            <!-- Total Scholarships -->
            <div class="col-12 col-sm-6 col-md-4 mb-4">
              <div class="card-body dashboard-card border-light">
                  <?php
                      // Assuming $userId is the ID of the logged-in user
                      $userId = $_SESSION['uid']; // Replace with actual user session or ID

                      // Query to count scholarships matching the user's department
                      $sql = "
                          SELECT COUNT(tblscheme.ID) AS TotalScholarships 
                          FROM tblscheme 
                          INNER JOIN tbluser 
                          ON tbluser.department = tblscheme.department 
                          WHERE tbluser.ID = :uid
                      ";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':uid', $userId, PDO::PARAM_INT);
                      $query->execute();
                      $result = $query->fetch(PDO::FETCH_OBJ);
                      $totalscheme = $result->TotalScholarships ?? 0; // Default to 0 if null
                  ?>
                  <h5 class="text-white mb-0"><?php echo htmlentities($totalscheme); ?>
                      <span class="float-right">Total Scholarships</span>
                  </h5>
                  <div class="progress my-3" style="height: 3px;">
                      <div class="progress-bar" style="width: 55%"></div>
                  </div>
                  <a href="views-scheme.php">
                      <p class="mb-0 text-white small-font">View Details <span class="float-right">
                          <i class="fa fa-arrow-right"></i></span></p>
                  </a>
              </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart Container -->
    <div style="width: 50%; margin: auto; margin-top: 30px;">
        <canvas id="scholarshipsPieChart"></canvas>
    </div>

    <!-- Pass PHP Data to JavaScript -->
    <script>
        const approvedApplications = <?php echo $approvedapp; ?>;
        const rejectedApplications = <?php echo $rejectedapp; ?>;
        const totalScholarships = <?php echo $totalscheme; ?>;
    </script>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('scholarshipsPieChart').getContext('2d');
        const data = {
            labels: ['Approved Scholarships', 'Rejected Scholarships', 'Total Scholarships'],
            datasets: [{
                label: 'Scholarship Distribution',
                data: [approvedApplications, rejectedApplications, totalScholarships],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)', // Approved - Green
                    'rgba(255, 99, 132, 0.7)', // Rejected - Red
                    'rgba(54, 162, 235, 0.7)'  // Total - Blue
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let value = tooltipItem.raw;
                                let label = tooltipItem.label;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>

        <!-- End Dashboard Content -->
        <div class="overlay toggle-menu"></div>
      </div>
    </div>
    <!-- End content-wrapper -->

    <!-- Start footer -->
    <?php include_once('includes/footer.php'); ?>
    <!-- End footer -->

  </div>
  <!-- End wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  
 <!-- simplebar js -->
  <script src="../assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="../assets/js/sidebar-menu.js"></script>
  <!-- loader scripts -->
  <script src="../assets/js/jquery.loading-indicator.js"></script>
  <!-- Custom scripts -->
  <script src="../assets/js/app-script.js"></script>
  <!-- Chart js -->
  
  <script src="../assets/plugins/Chart.js/Chart.min.js"></script>
 
  <!-- Index js -->
  <script src="../assets/js/index.js"></script>
</body>
</html>
<?php } ?>
