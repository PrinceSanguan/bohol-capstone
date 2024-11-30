<?php
session_start();
error_reporting(0);

// Include the database connection file
include('includes/dbconnection.php');

// Check if the session variable is set, if not redirect to logout
if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
    exit;
}
$img = $_SESSION['img'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('inc/links.php'); ?>
 
    <title>Scholarship Management System || Rejected Scholarship</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>
    <!-- Favicon -->
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- Simplebar CSS -->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Animate CSS -->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS -->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
    <!-- Custom Style -->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
  
</head>

<body class="bg-theme bg-theme9">

<!-- Start loader -->
<div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
            <div class="loader"></div>
        </div>
    </div>
</div>
<!-- End loader -->

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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rejected Scholarship</h5>
                            <div class="table-responsive">
                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Application Number</th>
                                            <th scope="col">Name of Scholarship</th>
                                            <th scope="col">Full Name</th> <!-- Changed this header -->
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Apply Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $uid = $_SESSION['uid'];
                                        $sql = "SELECT tbluser.ID as uid, tbluser.FirstName, tbluser.MiddleName, tbluser.LastName, tbluser.MobileNumber, tbluser.Email, tblscheme.ID as sid, tblscheme.SchemeName, tblapply.ID as appid, tblapply.ApplicationNumber, tblapply.ApplyDate, tblapply.Status
                                                FROM tblapply
                                                JOIN tbluser ON tblapply.UserID = tbluser.ID
                                                JOIN tblscheme ON tblapply.SchemeId = tblscheme.ID
                                                WHERE tblapply.Status = 'Rejected' AND tblapply.UserID = :uid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->ApplicationNumber); ?></td>
                                                    <td><?php echo htmlentities($row->SchemeName); ?></td>
                                                    <td><?php echo htmlentities($row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName); ?></td> <!-- Full name concatenated -->
                                                    <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                    <td><?php echo htmlentities($row->ApplyDate); ?></td>
                                                    <td>
                                                        <?php if (empty($row->Status)) { ?>
                                                            <span class="font-w600">Not Updated Yet</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-danger"><?php echo htmlentities($row->Status); ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a href="view-application-status.php?viewid=<?php echo htmlentities($row->appid); ?>" class="btn btn-primary btn-sm">View Detail</a>
                                                    </td>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->
            
            <!-- Start overlay -->
            <div class="overlay toggle-menu"></div>
            <!-- End overlay -->

        </div><!-- End container-fluid -->
        
    </div><!-- End content-wrapper -->
    
    <!-- Start Back To Top Button -->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- End Back To Top Button -->
    
    <!-- Start footer -->
    <?php include_once('includes/footer.php'); ?>
    <!-- End footer -->
    
    <!-- Start color switcher -->
    <!-- End color switcher -->
   
</div><!-- End wrapper -->

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

<!-- DataTable Initialization -->
<script type="text/javascript"> 
    let table = new DataTable('#myTable'); 
</script>

</body>
</html>
