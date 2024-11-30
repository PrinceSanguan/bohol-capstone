<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {


$pagetitle=$_POST['pagetitle'];
$pagedes=$_POST['pagedes'];
$mobnum=$_POST['mobnum'];
$email=$_POST['email'];
$Address=$_POST['address'];
$website_links=$_POST['website'];
$sql="update tblpage set PageTitle=:pagetitle,PageDescription=:pagedes,Email=:email,website_links=:website,Address=:address,MobileNumber=:mobnum where  PageType='contactus'";
$query=$dbh->prepare($sql);
$query->bindParam(':pagetitle',$pagetitle,PDO::PARAM_STR);
$query->bindParam(':pagedes',$pagedes,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':address',$Address,PDO::PARAM_STR);
$query->bindParam(':website',$website_links,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Contact us has been updated")</script>';


  }

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Scholarship Management System||Contact Us</title>
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
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
  
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

    <div class="row mt-3">
      <div class="col-lg-12">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Contact Us</div>
           <hr>
            <form method="post">
              <?php

$sql="SELECT * from  tblpage where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                       <div class="form-group">
            <label for="input-1">Page Title</label>
            <input type="text" class="form-control" id="exampleTextInput1" name="pagetitle" value="<?php  echo $row->PageTitle;?>" required='true'>
           </div>
           <div class="form-group">
            <label for="input-1">Email</label>
             <input type="text" class="form-control" id="exampleTextInput1" name="email" value="<?php  echo $row->Email;?>" required='true'>
           </div>
           <div class="form-group">
            <label for="input-1">Website Links</label>
             <input type="text" class="form-control" id="exampleTextInput1" name="website" value="<?php  echo $row->website_links;?>" required='true'>
           </div>
           <div class="form-group">
            <label for="input-1">Address</label>
             <input type="text" class="form-control" id="exampleTextInput1" name="address" value="<?php  echo $row->Address;?>" required='true'>
           </div>
           <div class="form-group">
            <label for="input-1">Mobile Number</label>
            <input type="text" name="mobnum" id="mobnum" required="true" value="<?php  echo $row->MobileNumber;?>" class="form-control" maxlength="11" pattern="[0-9]+">
           </div>
          
           <div class="form-group">
            <label for="input-2"> Description</label>
            <textarea type="text" name="pagedes" class="form-control" required='true' style="width:800px;"><?php  echo $row->PageDescription;?></textarea>
           </div>
         
           <?php $cnt=$cnt+1;}} ?>
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5" name="submit"><i class="icon-lock"></i> Update</button>
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
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
  <?php include_once('includes/footer.php');?>
  <!--End footer-->
  
  <!--start color switcher-->
   <?php include_once('includes/color-switcher.php');?>
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
<?php }  ?>