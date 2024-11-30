<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
$img = $_SESSION['img'];

// Check if user is logged in
if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
    exit();
}

// Handle profile update
if (isset($_POST['submit_profile'])) {
    $uid = $_SESSION['uid'];
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];

    $sql = "UPDATE tbluser SET FirstName = :firstname, MiddleName = :middlename, LastName = :lastname, MobileNumber = :mobilenumber, Email = :email WHERE ID = :uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':firstname', $firstName, PDO::PARAM_STR);
    $query->bindParam(':middlename', $middleName, PDO::PARAM_STR);
    $query->bindParam(':lastname', $lastName, PDO::PARAM_STR);
    $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Profile has been updated")</script>';
}

// Handle password change
if (isset($_POST['submit_password'])) {
    $uid = $_SESSION['uid'];
    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);

    $sql = "SELECT ID FROM tbluser WHERE ID = :uid AND Password = :cpassword";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $con = "UPDATE tbluser SET Password = :newpassword WHERE ID = :uid";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':uid', $uid, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();

        echo '<script>alert("Your password has been successfully changed")</script>';
    } else {
        echo '<script>alert("Your current password is incorrect")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || Profile/Setting</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>
    <!-- favicon -->
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- simplebar CSS -->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- animate CSS -->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS -->
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS -->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
    <!-- Custom Style -->
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    <script type="text/javascript">
        function checkpass() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password field does not match');
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
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
                <div class="row mt-3">
                    <!-- Profile Form -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Profile</div>
                                <hr>
                                <form method="post">
                                    <?php
                                    $uid = $_SESSION['uid'];
                                    $sql = "SELECT * FROM tbluser WHERE ID = :uid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) { ?>
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlentities($row->FirstName); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="middlename">Middle Name</label>
                                                <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlentities($row->MiddleName); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlentities($row->LastName); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="schoolid">School ID</label>
                                                <input type="text" class="form-control" id="schoolid" name="schoolid" value="<?php echo htmlentities($row->SchoolID); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlentities($row->Email); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobilenumber">Contact Number</label>
                                                <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo htmlentities($row->MobileNumber); ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="regdate">Registration Date</label>
                                                <input type="text" class="form-control" id="regdate" name="regdate" value="<?php echo htmlentities($row->RegDate); ?>" readonly>
                                            </div>
                                            
                                    <?php }
                                    } ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Form -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Change Password</div>
                                <hr>
                                <form method="post" onsubmit="return checkpass();" name="changepassword">
                                    <div class="form-group">
                                        <label for="currentpassword">Current Password</label>
                                        <input type="password" class="form-control" name="currentpassword" id="currentpassword" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="newpassword">New Password</label>
                                        <input type="password" class="form-control" name="newpassword" id="newpassword" onkeyup="checkPasswordStrength();" required>
                                        <small id="password-strength" class="form-text text-muted"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-light px-5" name="submit_password"><i class="icon-lock"></i> Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End container-fluid -->
        </div>
        <!-- End content-wrapper -->
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
