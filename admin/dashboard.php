<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Session check: if not logged in, redirect to the login page
if (strlen($_SESSION['aid']) == 0) {
  header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Scholarship Management System || Dashboard</title>

  <!-- loader-->
  <link href="../assets/css/pace.min.css" rel="stylesheet"/>
  <script src="../assets/js/pace.min.js"></script>
  <!--favicon-->
  <link href="image/bnsc123.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
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
      font-size: 24px;
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
      .dashboard-card {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

<body class="bg-theme bg-theme9">
  <!-- Start wrapper-->
  <div id="wrapper">
    <!--Start sidebar-wrapper-->
    <?php include_once('includes/sidebar.php'); ?>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <?php include_once('includes/header.php'); ?>
    <!--End topbar header-->

    <div class="clearfix"></div>

    <div class="content-wrapper">
      <div class="container-fluid">
      <style>
        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            height: 100%;
            transition: transform 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .chart-container {
            position: relative;
            height: 200px;
            width: 100%;
        }
        .btn-add-scholarship {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-light">
    <?php
        // Get all the database counts
        $sql = "SELECT * from tblapply where Status is null";
        $query = $dbh->prepare($sql);
        $query->execute();
        $newapp = $query->rowCount();

        $sql = "SELECT * from tblapply where Status='Approved'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $approvedapp = $query->rowCount();

        $sql = "SELECT * from tblapply where Status='Rejected'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $totalrejected = $query->rowCount();

        $sql = "SELECT * from tblapply";
        $query = $dbh->prepare($sql);
        $query->execute();
        $totalapps = $query->rowCount();

        $sql = "SELECT * from tbluser";
        $query = $dbh->prepare($sql);
        $query->execute();
        $totalusers = $query->rowCount();

        $sql = "SELECT * from tblscheme";
        $query = $dbh->prepare($sql);
        $query->execute();
        $totalscheme = $query->rowCount();
    ?>

    <div class="container py-4">

        <!-- First Row -->
        <div class="row mt-3">
            <div class="col-12 col-lg-6 mb-4">
                <div class="dashboard-card">
                    <h5 class="mb-3">Application Status Overview</h5>
                    <div class="chart-container">
                        <canvas id="applicationChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <a href="new-application.php" class="btn btn-sm btn-outline-primary">New Applications</a>
                        <a href="approved-application.php" class="btn btn-sm btn-outline-success">Approved</a>
                        <a href="rejected-application.php" class="btn btn-sm btn-outline-danger">Rejected</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-4">
                <div class="dashboard-card">
                    <h5 class="mb-3">Registration Overview</h5>
                    <div class="chart-container">
                        <canvas id="registrationChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <a href="reg-users.php" class="btn btn-sm btn-outline-primary">View All Users</a>
                        <a href="manage-scheme.php" class="btn btn-sm btn-outline-success">Manage Schemes</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row - Original PHP Cards as Backup -->
        <div class="row">
            <div class="col-12 col-md-4 mb-4">
                <div class="dashboard-card">
                    <h5><?php echo htmlentities($newapp); ?> <span class="float-end">New Applications</span></h5>
                    <div class="progress my-4">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <a href="new-application.php" class="card-link">View Details <i class="fas fa-arrow-right float-end"></i></a>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-4">
                <div class="dashboard-card">
                    <h5><?php echo htmlentities($approvedapp); ?> <span class="float-end">Approved Applications</span></h5>
                    <div class="progress my-4">
                        <div class="progress-bar bg-success" style="width:100%"></div>
                    </div>
                    <a href="approved-application.php" class="card-link">View Details <i class="fas fa-arrow-right float-end"></i></a>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-4">
                <div class="dashboard-card">
                    <h5><?php echo htmlentities($totalrejected); ?> <span class="float-end">Rejected Applications</span></h5>
                    <div class="progress my-4">
                        <div class="progress-bar bg-danger" style="width:100%"></div>
                    </div>
                    <a href="rejected-application.php" class="card-link">View Details <i class="fas fa-arrow-right float-end"></i></a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // PHP variables for charts
        const newApplications = <?php echo $newapp; ?>;
        const approvedApplications = <?php echo $approvedapp; ?>;
        const rejectedApplications = <?php echo $totalrejected; ?>;
        const totalUsers = <?php echo $totalusers; ?>;
        const totalSchemes = <?php echo $totalscheme; ?>;

        // Application Status Chart
        const applicationData = {
            labels: ['New', 'Approved', 'Rejected'],
            datasets: [{
                data: [newApplications, approvedApplications, rejectedApplications],
                backgroundColor: ['#36A2EB', '#4CAF50', '#FF6384']
            }]
        };

        // Registration Overview Chart
        const registrationData = {
            labels: ['Total Users', 'Total Schemes'],
            datasets: [{
                data: [totalUsers, totalSchemes],
                backgroundColor: ['#FF9F40', '#36A2EB']
            }]
        };

        // Create charts
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('applicationChart').getContext('2d'), {
                type: 'doughnut',
                data: applicationData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            new Chart(document.getElementById('registrationChart').getContext('2d'), {
                type: 'pie',
                data: registrationData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
        <!--End Dashboard Content-->
      </div>
    </div>

    <!-- Footer -->
    <?php include_once('includes/footer.php'); ?>
    <!--End Footer-->
  </div>

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
