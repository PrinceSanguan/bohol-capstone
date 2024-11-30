<?php
session_start();
include "../includes/dbconnection.php"; // Ensure this includes your PDO setup
require('inc/functions.php'); // Ensure functions.php is included
require('inc/essentials.php');
if (strlen($_SESSION['aid']==0)) {
    header('location:logout.php');
    } else{

// Ensure the update function is defined
if (!function_exists('update')) {
    function update($query, $values, $types = null) {
        global $dbh; // Access the global PDO instance
        $stmt = $dbh->prepare($query); // Prepare the SQL statement
        
        // Execute with bound parameters
        if ($types) {
            $stmt->execute($values); // If types are provided, bind them explicitly
        } else {
            $stmt->execute($values); // Execute directly if no types are needed
        }
        
        return $stmt->rowCount() > 0; // Return true if at least one row was affected
    }
}

if (isset($_SESSION['login'])) {
    if (isset($_GET['arc'])) {
        $frm_data = filteration($_GET);
        $q = "UPDATE user_queries SET is_archived = 1 WHERE sr_no = ?";
        $values = [$frm_data['arc']];
        
        if (update($q, $values)) { // No need to pass types
            echo "<script>alert('Archived successfully!'); window.location.href='user_queries.php';</script>";
        } else {
            echo "<script>alert('Operation Failed!');</script>";
        }
    }

    if (isset($_GET['seen'])) {
        $frm_data = filteration($_GET);
        $q = "UPDATE user_queries SET seen = 1 WHERE sr_no = ?";
        $values = [$frm_data['seen']];
        
        if (update($q, $values)) { // No need to pass types
            echo "<script>alert('Marked as read successfully!'); window.location.href='user_queries.php';</script>";
        } else {
            echo "<script>alert('Operation Failed!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<?php
  include('inc/links.php');
  ?>
  <title>Scholarship Management System||User_Queries Application</title>
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
              <h5 class="card-title">User Queries</h5>
              
              <!-- Button to navigate to archived queries -->
              <div class="mb-3">
                <a href="archived.php" class="btn btn-primary">View Archived Queries</a>
              </div>

              <div class="table-responsive">
                <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile No.</th>
                                        <th scope="col" width="30%">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // Query to select active queries
                                        $q = "SELECT * FROM user_queries WHERE is_archived = 0 ORDER BY sr_no DESC";
                                        $data = $dbh->query($q);

                                        while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                            // Archive button with confirmation
                                            $archiveBtn = "<a href='javascript:void(0);' onclick=\"confirmArchive('?arc=$row[sr_no]')\" class='btn btn-sm rounded-pill btn-warning mt-2' title='Archive'><i class='bi bi-archive me-1'></i> Archive</a>";
                                            $seen = '';
                                            if($row['seen'] !=1){
                                              $seen = "<a href='javascript:void(0);' onclick=\"confirmMarkRead('?seen=$row[sr_no]')\" class='btn btn-sm rounded-pill btn-success mt-2' title='Mark as Read'><i class='bi bi-check-circle me-1'></i> Mark as Read</a>";
                                            }
                                            

                                            echo <<< query
                                            <tr>
                                                <td>$row[name]</td>
                                                <td>$row[email]</td>
                                                <td>$row[mobilenumber]</td>
                                                <td>$row[message]</td>
                                                <td>$row[date]</td>
                                                <td>$row[time]</td>
                                                <td>$archiveBtn $seen</td>
                                            </tr>
                                        query;
                                        }
                                    ?>
                                 </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="overlay toggle-menu"></div>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

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

    <script>
        function confirmArchive(link) {
            if (confirm("Are you sure you want to archive this query?")) {
                window.location.href = link;
            }
        }

        function confirmMarkRead(link) {
            if (confirm("Are you sure you want to mark this query as read?")) {
                window.location.href = link;
            }
        }
    </script>
</body>

</html>
<?php 
} else {
    header("Location: login.php");
}
?>
<?php }  ?>
