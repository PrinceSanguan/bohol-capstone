<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$img = $_SESSION['img'];
if (strlen($_SESSION['uid']==0)) {
  header('location:logout.php');
} else {
  if(isset($_POST['submit'])) {
    $uid=$_SESSION['uid'];
    $appnumber=$_GET['appnumber'];
    $accholdername=$_POST['accholdername'];
    $bankname=$_POST['bankname'];
    $branchname=$_POST['branchname'];
    $ifsc=$_POST['ifsc'];
    $accountnumber=$_POST['accountnumber'];
    $sql= "insert into tblbankdetails(ApplicationNumber,UserID,AccountHoldername,BankName,BranchName,IFSCCode,AccountNumber)values(:appnumber,:uid,:accholdername,:bankname,:branchname,:ifsc,:accountnumber)";
    $query=$dbh->prepare($sql);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->bindParam(':appnumber',$appnumber,PDO::PARAM_STR);
    $query->bindParam(':accholdername',$accholdername,PDO::PARAM_STR);
    $query->bindParam(':bankname',$bankname,PDO::PARAM_STR);
    $query->bindParam(':branchname',$branchname,PDO::PARAM_STR);
    $query->bindParam(':ifsc',$ifsc,PDO::PARAM_STR);
    $query->bindParam(':accountnumber',$accountnumber,PDO::PARAM_STR);
    $query->execute();
    $LastInsertId=$dbh->lastInsertId();
    if ($LastInsertId>0) {
      echo '<script>alert("Bank Details has been sent")</script>';
      echo "<script>window.location.href ='application-history.php'</script>";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System | View Scheme</title>
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
<div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
            <div class="loader"></div>
        </div>
    </div>
</div>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">View Scholarship Scheme</h5>
                            <div>
                                <?php
                                $vid = $_GET['viewid'];
                                $sql = "SELECT 
                                            tbluser.ID as uid,
                                            tbluser.FirstName,
                                            tbluser.MiddleName,
                                            tbluser.LastName,
                                            tbluser.SuffixName,
                                            
                                            tbluser.MobileNumber,
                                            tbluser.Course,
                                            tbluser.DateofBirth,
                                            tbluser.Gender,
                                            tbluser.department,

                                            tbluser.Citizenship,
                                            tbluser.CivilStatus,
                                            tbluser.YearLevel,
                                            
                                            tbluser.Address,
                                            tbluser.ZipCode,
                                            tbluser.Email,
                                            tbluser.RegDate,
                                            tbluser.SchoolID,
                                            tblscheme.ID as sid,
                                            tblscheme.SchemeName,
                                          
                                            tblscheme.Yearofscholarship,
                                            
                                            tblscheme.LastDate,
                                            tblscheme.Requirements,
                                            tblscheme.Scholarfee,
                                            tblscheme.PublishedDate,
                                            tblapply.ID as appid,
                                            tblapply.ApplicationNumber,
                                            tblapply.ApplyDate,
                                            tblapply.Status,
                                            tblapply.DocReq,
                                            tblapply.Remark
                                        FROM 
                                            tblapply 
                                        JOIN 
                                            tbluser ON tblapply.UserID = tbluser.ID 
                                        JOIN 
                                            tblscheme ON tblapply.SchemeId = tblscheme.ID 
                                        WHERE 
                                            tblapply.ID = :vid";

                                $query = $dbh->prepare($sql);
                                $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) { ?>
                                        <table border="1" class="table table-bordered">
                                            <tr align="center">
                                                <td style="color:red" colspan="2"> View Scholarship Scheme Details</td>
                                            </tr>
                                            <tr>
                                                <th>Name of Scholarship</th>
                                                <td colspan="4"> <?php echo $row->SchemeName; ?></td>

                                            </tr>
                                            
                                            <tr>
                                                <th>Year of Scholarship</th>
                                                <td><?php echo $row->Yearofscholarship; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Last Date</th>
                                                <td><?php echo $row->LastDate; ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Requirement for Scholarship</th>
                                                <td colspan="4"><?php echo $row->Requirements; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Scholarship Tuition Fee</th>
                                                <td><?php echo $row->Scholarfee; ?></td>
                                            </tr>
                                        </table>
                                        <table border="1" class="table table-bordered">
                                            <tr align="center">
                                                <td style="font-size:15px;color:red"> View Application Details: <?php echo $row->ApplicationNumber; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Fullname of Applicant</th>
                                                <td><?php echo $row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName. ' ' . $row->SuffixName; ?></td>
                                               <th>Department Status</th>
                                                <td><?php echo $row->department; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $row->Email; ?></td>
                                                <th>School ID</th>
                                                <td><?php echo $row->SchoolID; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td><?php echo $row->DateofBirth; ?></td>
                                                <th>Gender</th>
                                                <td><?php echo $row->Gender; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $row->Address; ?></td>
                                                <th>Mobile Number</th>
                                                <td><?php echo $row->MobileNumber; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Zip Code</th>
                                                <td><?php echo $row->ZipCode; ?></td>
                                                <th>Citizenship</th>
                                                <td><?php echo $row->Citizenship; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Civil Status</th>
                                                <td><?php echo $row->CivilStatus; ?></td>
                                                <th>Year Level</th>
                                                <td><?php echo $row->YearLevel; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Course</th>
                                                <td><?php echo $row->Course; ?></td>
                                                <th>Document Details</th>
                                                <td><a href="../users/document/<?php echo $row->DocReq; ?>" target="blank" class="btn btn-primary" title="For View Doc Click here">View</a></td>
                                            </tr>
                                            
                                            <tr>
                      <th colspan="4" style="color: red;font-weight: bold;font-size: 15px">Admin Remarks:</th>
                    </tr>
                    <tr>
    <th scope="col">Application Status</th>
    <td>
        <?php
        $status = $row->Status;
        if ($status == "Approved") {
            echo "Approved";
        } elseif ($status == "Rejected") {
            echo "Rejected";
        } else {
            echo "Not Responded Yet";
        }
        ?>
    </td>
    <th scope="col">Admin Remark</th>
    <td>
        <?php
        if ($status == "") {
            echo "Not Updated Yet";
        } else {
            echo htmlentities($row->Remark);
        }
        ?>
    </td>
</tr>


                                        </table>
                                        <?php $cnt=$cnt+1;}} ?>
                                    
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row-->

        </div>
        <!-- End container-fluid-->

    </div>
    <!-- End content-wrapper-->
    <?php include_once('includes/footer.php'); ?>

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

<!-- Custom scripts -->
<script src="../assets/js/app-script.js"></script>

<!-- End wrapper-->
</body>
</html>
<?php } ?>
