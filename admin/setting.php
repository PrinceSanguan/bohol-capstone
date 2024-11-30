<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['aid'] == 0)) {
    header('location:logout.php');
} else {
    // Update Profile
    if (isset($_POST['submit_profile'])) {
        $adminid = $_SESSION['aid'];
        $AName = $_POST['adminname'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];

        // Handle file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $target_dir = "../uploads/"; // Adjust the path as needed
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size (5MB limit)
            if ($_FILES["photo"]["size"] > 5000000) {
                echo '<script>alert("Sorry, your file is too large.")</script>';
            } else {
                // Allow certain file formats
                if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
                } else {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        // Update profile with the new image path
                        $sql = "UPDATE tbladmin SET AdminName=:adminname, MobileNumber=:mobilenumber, Email=:email, Photo=:photo WHERE ID=:aid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
                        $query->bindParam(':email', $email, PDO::PARAM_STR);
                        $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
                        $query->bindParam(':photo', basename($_FILES["photo"]["name"]), PDO::PARAM_STR);
                        $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
                        $query->execute();
                        echo '<script>alert("Profile has been updated")</script>';
                    } else {
                        echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
                    }
                }
            }
        } else {
            // Update profile without changing the photo
            $sql = "UPDATE tbladmin SET AdminName=:adminname, MobileNumber=:mobilenumber, Email=:email WHERE ID=:aid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
            $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
            $query->execute();
            echo '<script>alert("Profile has been updated")</script>';
        }
    }

    // Change Password
    if (isset($_POST['submit_password'])) {
        $adminid = $_SESSION['aid'];
        $cpassword = md5($_POST['currentpassword']);
        $newpassword = md5($_POST['newpassword']);
        $sql = "SELECT ID FROM tbladmin WHERE ID=:adminid AND Password=:cpassword";
        $query = $dbh->prepare($sql);
        $query->bindParam(':adminid', $adminid, PDO::PARAM_STR);
        $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            $con = "UPDATE tbladmin SET Password=:newpassword WHERE ID=:adminid";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':adminid', $adminid, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            echo '<script>alert("Your password has been successfully changed")</script>';
        } else {
            echo '<script>alert("Your current password is wrong")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Scholarship Management System || Profile and Settings</title>
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/icons.css" rel="stylesheet"/>
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
    <link href="../assets/css/app-style.css" rel="stylesheet"/>

    <script type="text/javascript">
    function checkpass() {
        if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
            alert('New Password and Confirm Password fields do not match');
            document.changepassword.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>
</head>

<body class="bg-theme bg-theme9">
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <div id="wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>
        <div class="clearfix"></div>
        
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Profile</div>
                                <hr>
                                <form method="post" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
                                    <?php
                                    $sql = "SELECT * FROM tbladmin WHERE ID=:aid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':aid', $_SESSION['aid'], PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) { ?>
                                            <div class="form-group">
                                                <label for="input-1">Admin Name</label>
                                                <input type="text" class="form-control" id="adminname" name="adminname" value="<?php echo $row->AdminName; ?>" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-2">User Name</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row->UserName; ?>" readonly="true">
                                            </div>
                                            <div class="form-group">
                                                <label for="input-3">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row->Email; ?>" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-4">Contact Number</label>
                                                <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo $row->MobileNumber; ?>" required='true' maxlength='10'>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-5">Admin Registration Date</label>
                                                <input type="text" class="form-control" id="regdate" name="regdate" value="<?php echo $row->AdminRegdate; ?>" readonly="true">
                                            </div>
                                            <div class="form-group">
                                                <div class="card-title">Admin Upload Photo</div>
                                                
                                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                                <small class="form-text text-muted">Allowed formats: jpg, jpeg, png, gif</small>
                                            </div>
                                        <?php }
                                    } ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-light px-5" name="submit_profile"><i class="icon-lock"></i> Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Change Password</div>
                                <hr>
                                <form method="post" onsubmit="return checkpass();" name="changepassword">
                                    <div class="form-group">
                                        <label for="currentpassword">Current Password</label>
                                        <input type="password" class="form-control" id="currentpassword" name="currentpassword" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="newpassword">New Password</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required="true">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-light px-5" name="submit_password"><i class="icon-lock"></i> Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Upload User Photo</div>
                                <hr>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="user_id">Select User</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <?php
                                            // Fetch users from the database
                                            $sql = "SELECT ID, FirstName, LastName FROM tbluser";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $users = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($users as $user) {
                                                echo '<option value="' . htmlentities($user->ID) . '">' . htmlentities($user->FirstName . ' ' . $user->LastName) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_photo">Upload New Photo</label>
                                        <input type="file" class="form-control" id="user_photo" name="user_photo" accept="image/*" required>
                                        <small class="form-text text-muted">Allowed formats: jpg, jpeg, png, gif</small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-light px-5" name="submit_user_photo"><i class="icon-upload"></i> Upload Photo</button>
                                    </div>
                                </form>
                                <?php
                                // Handle user photo upload
                                if (isset($_POST['submit_user_photo'])) {
                                    $userId = $_POST['user_id'];
                                    $target_dir = "../uploads/";
                                    $target_file = $target_dir . basename($_FILES["user_photo"]["name"]);
                                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                                    // Check file size (5MB limit)
                                    if ($_FILES["user_photo"]["size"] > 5000000) {
                                        echo '<script>alert("Sorry, your file is too large.")</script>';
                                    } else {
                                        // Allow certain file formats
                                        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                                            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
                                        } else {
                                            // Move the uploaded file to the target directory
                                            if (move_uploaded_file($_FILES["user_photo"]["tmp_name"], $target_file)) {
                                                // Update user photo path in the database
                                                $sql = "UPDATE tbluser SET Photo=:photo WHERE ID=:userid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':photo', basename($_FILES["user_photo"]["name"]), PDO::PARAM_STR);
                                                $query->bindParam(':userid', $userId, PDO::PARAM_STR);
                                                $query->execute();
                                                echo '<script>alert("User photo has been updated")</script>';
                                            } else {
                                                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/jquery.loading-indicator.js"></script>
    <script src="../assets/js/app-script.js"></script>
    <script src="../assets/plugins/Chart.js/Chart.min.js"></script>
    <script src="../assets/js/index.js"></script>
</body>
</html>
<?php } ?>