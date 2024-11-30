<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php
  include('inc/links.php');
  ?>
  <title>Scholarship Management System||Approved Application</title>
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
              <h5 class="card-title">Approved Application</h5>
              <div class="table-responsive">
                <table class="table" id="myTable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Application Number</th>
                      <th scope="col">Name of Scholarship</th>
                      <th scope="col">First Name</th>
                      <th scope="col">Middle Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Gender</th>
                      <th scope="col">Birthdate</th>
                      <th scope="col">Degree Program</th>
                      <th scope="col">Year Level</th>
                      <th scope="col">Zip Code</th>
                      <th scope="col">E-mail adress</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$sql="SELECT tbluser.ID as uid,tbluser.FirstName,tbluser.MiddleName,tbluser.LastName,tbluser.Gender,tbluser.DateofBirth,tbluser.Course,tbluser.YearLevel,tbluser.ZipCode,tbluser.Email,tblscheme.ID as sid,tblscheme.SchemeName,tblapply.ID as appid,tblapply.ApplicationNumber,tblapply.Status,tblapply.Status from tblapply join tbluser on tblapply.UserID=tbluser.ID join tblscheme on tblapply.SchemeId=tblscheme.ID where tblapply.Status='Approved'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                    <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                               
                                                <td><?php  echo htmlentities($row->ApplicationNumber);?></td>
                                                <td><?php  echo htmlentities($row->SchemeName);?></td>
                                                <td><?php  echo htmlentities($row->FirstName);?></td>
                                                <td><?php  echo htmlentities($row->MiddleName);?></td>
                                                <td><?php  echo htmlentities($row->LastName);?></td>
                                                <td><?php  echo htmlentities($row->Gender);?></td>
                                                <td><?php  echo htmlentities($row->DateofBirth);?></td>
                                                <td><?php  echo htmlentities($row->Course);?></td>
                                                <td><?php  echo htmlentities($row->YearLevel);?></td>
                                                <td><?php  echo htmlentities($row->ZipCode);?></td>
                                                <td><?php  echo htmlentities($row->Email);?></td>


                                                <?php if($row->Status==""){ ?>

                     <td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>
                                        <td>
                                            <span class="badge badge-success"><?php  echo htmlentities($row->Status);?></span>
                                        </td><?php } ?> 
                                                <td><a href="view-application.php?viewid=<?php echo htmlentities ($row->appid);?>" class="btn btn-primary btn-sm">View Detail</a>

                                                </td>
                                            </tr>
                                    <?php $cnt=$cnt+1;}} ?> 
                
                   
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