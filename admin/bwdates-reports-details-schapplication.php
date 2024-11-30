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
<?php
  include('inc/links.php');
  ?>
  
  <title>Scholarship Management System || Manage Scheme</title>
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
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

  <!--Start sidebar-wrapper-->
    <?php include_once('includes/sidebar.php'); ?>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<?php include_once('includes/header.php'); ?>
<!--End topbar header-->
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Capture form inputs
                        $fdate = $_POST['fromdate'];
                        $tdate = $_POST['todate'];
                        $scholarshipID = $_POST['scholarship']; // Get the selected scholarship ID

                        // Query to get the scholarship name
                        $sql = "SELECT SchemeName FROM tblscheme WHERE ID = :scholarshipID";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':scholarshipID', $scholarshipID, PDO::PARAM_INT);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_OBJ);
                        $scholarshipName = $result->SchemeName;

                        ?>
                        <!-- Show selected date range and scholarship name -->
                        <h5 class="card-title">Scholarship Applications From <?php echo htmlentities($fdate); ?> to <?php echo htmlentities($tdate); ?> for <?php echo htmlentities($scholarshipName); ?></h5>
                        <div class="table-responsive">

                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Application Number</th>
                                        <th scope="col">Name of Scholarship</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Apply Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Updated SQL query to filter based on date range and selected scholarship, and concatenate names
                                    $sql = "SELECT tbluser.ID as uid, 
                                                   CONCAT(tbluser.FirstName, ' ', tbluser.MiddleName, ' ', tbluser.LastName) as FullName, 
                                                   tbluser.MobileNumber, tbluser.Email, 
                                                   tblscheme.ID as sid, tblscheme.SchemeName, 
                                                   tblapply.ID as appid, tblapply.ApplicationNumber, 
                                                   tblapply.ApplyDate, tblapply.Status
                                            FROM tblapply 
                                            JOIN tbluser ON tblapply.UserID=tbluser.ID 
                                            JOIN tblscheme ON tblapply.SchemeId=tblscheme.ID 
                                            WHERE date(tblapply.ApplyDate) BETWEEN '$fdate' AND '$tdate' 
                                            AND tblapply.SchemeId = :scholarshipID";

                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':scholarshipID', $scholarshipID, PDO::PARAM_INT);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row->ApplicationNumber); ?></td>
                                        <td><?php echo htmlentities($row->SchemeName); ?></td>
                                        <td><?php echo htmlentities($row->FullName); ?></td>
                                        <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                        <td><?php echo htmlentities($row->ApplyDate); ?></td>
                                        <?php if ($row->Status == "") { ?>
                                            <td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
                                        <?php } else { ?>
                                            <td><span class="badge badge-primary"><?php echo htmlentities($row->Status); ?></span></td>
                                        <?php } ?>
                                        <td><a href="view-application.php?viewid=<?php echo htmlentities($row->appid); ?>" class="btn btn-primary btn-sm">View Detail</a></td>
                                    </tr>
                                    <?php
                                            $cnt = $cnt + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
  <!--End Row-->
    
    <!--start overlay-->
      <div class="overlay toggle-menu"></div>
    <!--end overlay-->

    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
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
  
  <!-- Custom scripts -->
  <script src="../assets/js/app-script.js"></script>
  <script type="text/javascript"> let table = new DataTable('#myTable');</script>
  
</body>
</html>
<?php } ?>
