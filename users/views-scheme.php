<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['uid']==0)) {
  header('location:logout.php');
  } else{
$img = $_SESSION['img'];


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php
  include('inc/links.php'); 
  ?>
  <title>Scholarship Management System||View Scheme</title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <?php include_once('includes/sidebar.php');?>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<?php include_once('includes/header.php');?>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">View Scholarship </h5>
              <div class="table-responsive">
              <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name of Scholarship</th>
                        <th scope="col">Last Date</th>
                        <th scope="col">Published Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Assuming $userId is the ID of the logged-in user
                    $userId = $_SESSION['uid']; // Replace with actual user session or ID

                    // Query to fetch scholarships matching the user's department
                    $sql = "
                        SELECT tblscheme.* 
                        FROM tblscheme 
                        INNER JOIN tbluser 
                        ON tbluser.department = tblscheme.department 
                        WHERE tbluser.ID = :uid
                    ";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':uid', $userId, PDO::PARAM_INT);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;

                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                            // Handle potential NULL values
                            $schemeName = htmlentities($row->SchemeName ?? 'N/A');
                            $lastDate = htmlentities($row->LastDate ?? 'N/A');
                            $publishedDate = htmlentities($row->PublishedDate ?? 'N/A');
                            ?>
                            <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo $schemeName; ?></td>
                                <td><?php echo $lastDate; ?></td>
                                <td><?php echo $publishedDate; ?></td>
                                <td>
                                    <a href="view-scheme-detail.php?viewid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary btn-sm">
                                        View Detail
                                    </a>
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
      </div><!--End Row-->
	  
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
	<?php include_once('includes/footer.php');?>
	<!--End footer-->
	
	<!--start color switcher-->

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
  
  <!-- Custom scripts -->
  <script src="../assets/js/app-script.js"></script>
  <script type="text/javascript"> let table = new DataTable('#myTable');</script>
	
</body>
</html>
<?php }  ?>