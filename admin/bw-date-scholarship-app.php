<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Scholarship Management System | B/W Dates Report of Scholarship Application</title>
  <!-- loader-->
  <link href="../assets/css/pace.min.css" rel="stylesheet"/>
  <script src="../assets/js/pace.min.js"></script>
  <!--favicon-->
  <link href="image/bnsc123.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
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
  
</head>

<body class="bg-theme bg-theme9">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>
   <!-- end loader -->

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

    <div class="row mt-3">
      <div class="col-lg-6">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Date Scholarship</div>
           <hr>
            <form method="post" name="bwdatesreportschapp" action="bwdates-reports-details-schapplication.php">
              
           <div class="form-group">
            <label for="fromdate">From Date</label>
            <input type="date" class="form-control" id="fromdate" name="fromdate" required="true">
           </div>
           
           <div class="form-group">
            <label for="todate">To Date</label>
            <input type="date" class="form-control" id="todate" name="todate" required="true">
           </div>

           <!-- Scholarship Selection -->
           <div class="form-group">
            <label for="scholarship">Select Scholarship</label>
            <select class="form-control" id="scholarship" name="scholarship" required="true">
              <option value="">--Select Scholarship--</option>
              <?php
              $sql = "SELECT * FROM tblscheme";  // Fetch available scholarships
              $query = $dbh->prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              
              if ($query->rowCount() > 0) {
                  foreach ($results as $row) {
                      echo '<option value="' . $row->ID . '">' . $row->SchemeName . '</option>';
                  }
              }
              ?>
            </select>
           </div>

           <div class="form-group">
            <button type="submit" class="btn btn-light px-5" name="submit"><i class="icon-lock"></i> Submit</button>
          </div>
          </form>
         </div>
         </div>
      </div>
    </div><!--End Row-->

    <!--start overlay-->
      <div class="overlay toggle-menu"></div>
    <!--end overlay-->

    </div>
    <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->
   
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!--End Back To Top Button-->
  
  <!--Start footer-->
  <?php include_once('includes/footer.php'); ?>
  <!--End footer-->
  
  <!--start color switcher-->
   <?php include_once('includes/color-switcher.php'); ?>
  <!--end color switcher-->
   
  </div><!--End wrapper-->


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
