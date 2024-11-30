<?php 
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $mname = $_POST['mname'] ?? ''; // Default to empty string if not set
        $lname = $_POST['lname'];
        $suffix = $_POST['suffix'] ?? ''; // Default to empty string if not set
        $schoolid = $_POST['schoolid'];
        $mobno = $_POST['mobno'];
        $course = $_POST['course'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $cship = $_POST['cship'];
        $cstatus = $_POST['cstatus'];
        $yrlevel = $_POST['yrlevel'];
        $address = $_POST['address'];
        $zipcode = $_POST['zipcode'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        
        $photo = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_folder = "../uploads/" . basename($photo);
    
        try {
            $ret = "SELECT Email, SchoolID FROM tbluser WHERE Email=:email OR SchoolID=:SchoolID";
            $query = $dbh->prepare($ret);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':SchoolID', $schoolid, PDO::PARAM_STR);
            $query->execute();
            
            if ($query->rowCount() == 0) {
                if ($_FILES['photo']['error'] == UPLOAD_ERR_OK && move_uploaded_file($photo_tmp, $photo_folder)) {
                    $sql = "INSERT INTO tbluser (FirstName, MiddleName, LastName, SuffixName, SchoolID, MobileNumber, Course, DateofBirth, Gender, Citizenship, CivilStatus, YearLevel, Address, ZipCode, Email, Password, Photo) 
                            VALUES (:fname, :mname, :lname, :suffix, :schoolid, :mobno, :course, :dob, :gender, :cship, :cstatus, :yrlevel, :address, :zipcode, :email, :password, :photo)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                    $query->bindParam(':mname', $mname, PDO::PARAM_STR); // Optional field
                    $query->bindParam(':lname', $lname, PDO::PARAM_STR);
                    $query->bindParam(':suffix', $suffix, PDO::PARAM_STR); // Optional field
                    $query->bindParam(':schoolid', $schoolid, PDO::PARAM_STR);
                    $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
                    $query->bindParam(':course', $course, PDO::PARAM_STR);
                    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                    $query->bindParam(':cship', $cship, PDO::PARAM_STR);
                    $query->bindParam(':cstatus', $cstatus, PDO::PARAM_STR);
                    $query->bindParam(':yrlevel', $yrlevel, PDO::PARAM_STR);
                    $query->bindParam(':address', $address, PDO::PARAM_STR);
                    $query->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':password', $password, PDO::PARAM_STR);
                    $query->bindParam(':photo', basename($photo), PDO::PARAM_STR);
                    $query->execute();
                    
                    $lastInsertId = $dbh->lastInsertId();
                    if ($lastInsertId) {
                        echo "<script>alert('You have successfully registered with us');</script>";
                        header("Location: reg-users.php");
                        exit();
                    } else {
                        echo "<script>alert('Something went wrong. Please try again');</script>";
                    }
                } else {
                    echo "<script>alert('Failed to upload the file.');</script>";
                }
            } else {
                echo "<script>alert('Email ID or School ID already exists. Please try again');</script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || Registration Page</title>
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="../assets/css/pace.min.css" rel="stylesheet"/>
    <script src="../assets/js/pace.min.js"></script>
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
      /* Wrapper to center content */
      #wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 15px;
      }

      /* Responsive card design */
      .card-authentication1 {
        width: 100%;
        max-width: 1000px; /* Adjusted to make it wider */
        padding: 20px;
        margin: auto;
      }

      /* Responsive form elements */
      .form-row {
        display: flex;
        flex-wrap: wrap;
      }

      .form-group {
        flex: 1;
        padding: 10px;
      }

      /* Responsive input alignment */
      .form-group input, .form-group select {
        width: 100%;
      }

      /* For better icon positioning */
      .position-relative {
        position: relative;
      }

      .form-control-position {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
      }

      /* Button style */
      button[type="submit"] {
        margin-top: 15px;
        width: 100%;
      }

      /* Media query for smaller screens */
      @media (max-width: 768px) {
        .form-row {
          display: block;
        }
      }
    </style>
</head>
<body class="bg-theme bg-theme9">
    <div id="wrapper">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        <div class="card card-authentication1">
            <div class="card-body">
                <div class="card-content">
                    <div class="card-title text-uppercase text-center py-3">Student Sign Up</div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="fname" name="fname" class="form-control" placeholder="Enter Firstname" required>
                                    <div class="form-control-position">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="mname" name="mname" class="form-control" placeholder="Enter Middlename">
                                    <div class="form-control-position">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="lname" name="lname" class="form-control" placeholder="Enter Lastname" required>
                                    <div class="form-control-position">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Suffix Name</label>
                                <div class="position-relative has-icon-right">
                                    <select id="suffix" name="suffix" class="form-control">
                                        <option value="" selected>Optional</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fa fa-user-tag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>School ID</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="schoolid" name="schoolid" class="form-control" placeholder="Enter School ID" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-id-card"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <div class="position-relative has-icon-right">
                                    <input type="tel" id="mobno" name="mobno" class="form-control" placeholder="Enter Mobile Number" 
                                    required maxlength="11" pattern="\d{11}" title="Please enter an 11-digit mobile number">
                                    <div class="form-control-position">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Course</label>
                                <div class="position-relative has-icon-right">
                                    <select id="course" name="course" class="form-control" required>
                                        <option value="">Select Course</option>
                                        <option value="BSCS">BS Computer Science</option>
                                        <option value="BSIT">BS Information Technology</option>
                                        <option value="BSCriminology">BS Criminology</option>
                                        <option value="BSA">BS Accountancy</option>
                                        <option value="BSBA">BS Business Administration</option>
                                        <option value="BSED">BS Education</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fa fa-book"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <div class="position-relative has-icon-right">
                                    <input type="date" id="dob" name="dob" class="form-control" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="position-relative has-icon-right">
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fa fa-venus-mars"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Citizenship</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="cship" name="cship" class="form-control" placeholder="Enter Citizenship" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-flag"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Civil Status</label>
                                <div class="position-relative has-icon-right">
                                    <select id="cstatus" name="cstatus" class="form-control" required>
                                        <option value="">Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fa fa-user-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Year Level</label>
                                <div class="position-relative has-icon-right">
                                    <select id="yrlevel" name="yrlevel" class="form-control" required>
                                        <option value="">Select Year Level</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                        <option value="5th Year">5th Year</option>
                                    </select>
                                    <div class="form-control-position">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-home"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Zip Code</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Enter Zip Code" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-map-pin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="position-relative has-icon-right">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label>Password</label>
                            <div class="position-relative has-icon-right">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                                <span class="form-control-position" onclick="togglePasswordVisibility()">
                                    <i id="toggleEyeIcon" class="fa fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Upload Photo</label>
                                <div class="position-relative has-icon-right">
                                    <input type="file" id="photo" name="photo" class="form-control" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-upload"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
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
  <script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleEyeIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}
</script>


</body>
</html>
