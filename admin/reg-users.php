<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit();
}

if ($_GET['del']) {
    $uid = $_GET['del'];
    $sql = "DELETE FROM tbluser WHERE ID=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_INT);
    $query->execute();
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='reg-users.php'</script>";
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'];
    $suffix = $_POST['suffix'] ?? '';
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
    $department = $_POST['department'];
    
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_folder = "../uploads/" . basename($photo);

    try {
        // Check for duplicate Email or SchoolID
        $ret = "SELECT Email, SchoolID FROM tbluser WHERE Email=:email OR SchoolID=:SchoolID";
        $query = $dbh->prepare($ret);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':SchoolID', $schoolid, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->rowCount() == 0) {
            // Upload photo
            if (!empty($photo) && move_uploaded_file($photo_tmp, $photo_folder)) {
                $photoName = basename($photo);
            } else {
                $photoName = null; // Handle case where no photo is uploaded
            }

            // Insert data into tbluser
            $sql = "INSERT INTO tbluser (FirstName, MiddleName, LastName, SuffixName, SchoolID, MobileNumber, Course, DateofBirth, Gender, Citizenship, CivilStatus, YearLevel, Address, ZipCode, Email, Password, Photo, department) 
                    VALUES (:fname, :mname, :lname, :suffix, :schoolid, :mobno, :course, :dob, :gender, :cship, :cstatus, :yrlevel, :address, :zipcode, :email, :password, :photo, :department)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':mname', $mname, PDO::PARAM_STR);
            $query->bindParam(':lname', $lname, PDO::PARAM_STR);
            $query->bindParam(':suffix', $suffix, PDO::PARAM_STR);
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
            $query->bindParam(':photo', $photoName, PDO::PARAM_STR);
            $query->bindParam(':department', $department, PDO::PARAM_STR);
            $query->execute();

            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                echo "<script>alert('You have successfully registered with us');</script>";
                echo "<script>window.location.href='reg-users.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        } else {
            echo "<script>alert('Email ID or School ID already exists. Please try again');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('inc/links.php'); ?>
    <title>Scholarship Management System || Manage Registered Users</title>
    <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <!--favicon-->
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- simplebar CSS-->
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="../assets/css/app-style.css" rel="stylesheet" />

    <style>
      /* Modal styling */
      .modal-content {
        background-color:#343a40; /* Gray background for better readability */
        color: white; /* Dark text color for contrast */
        border-radius: 8px; /* Rounded corners */
        padding: 20px; /* Padding for content */
        width: 125%;
 
      }

      .modal-header {
        border-bottom: 1px solid #dee2e6; /* Subtle border for separation */
      }

      .modal-title {
        font-weight: bold; /* Bold title for emphasis */
      }

      .form-group label {
        font-weight: 500; /* Medium weight for labels */
        color: white; /* Ensure label text is black */
      }

      .form-control {
        border-radius: 4px; /* Slightly rounded inputs */
        border: 1px solid #ced4da; /* Border color */
        color: black; /* Ensure input text is black */
      }

      .btn-primary {
        background-color: #007bff; /* Primary button color */
        border-color: #007bff; /* Border color */
      }

      .btn-primary:hover {
        background-color: #0056b3; /* Darker shade on hover */
        border-color: #0056b3; /* Border color on hover */
      }

      /* Responsive form elements */
      .form-row {
        display: flex;
        flex-wrap: wrap;
      }

      .form-group {
        flex: 1 1 45%; /* Flex items to take up 45% of the row */
        padding: 10px;
      }

      /* Media query for smaller screens */
      @media (max-width: 768px) {
        .form-group {
          flex: 1 1 100%; /* Full width on smaller screens */
        }
      }
    </style>
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
                            <h5 class="card-title">Manage Students</h5>
                            <!-- Add Student Button -->
                            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStudentModal">Add Student</a>
                            <div class="table-responsive">
                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">School ID</th>
                                            <th scope="col">Mobile Number</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Registration Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM tbluser";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->FirstName . ' ' . $row->MiddleName . ' ' . $row->LastName); ?></td>
                                                    <td><?php echo htmlentities($row->SchoolID); ?></td>
                                                    <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                    <td><?php echo htmlentities($row->Email); ?></td>
                                                    <td><?php echo htmlentities($row->RegDate); ?></td>
                                                    <td>
                                                        <a href="reg-users.php?del=<?php echo htmlentities($row->ID); ?>" onclick="return confirm('Do you really want to delete?');" class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                </tr>
                                        <?php 
                                            $cnt = $cnt + 1; 
                                            } 
                                        } ?> 
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
    <?php include_once('includes/footer.php'); ?>
    <!--End footer-->

    <!--start color switcher-->
    <?php include_once('includes/color-switcher.php'); ?>
    <!--end color switcher-->

</div><!--End wrapper-->

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
              <label>Suffix</label>
              <div class="position-relative has-icon-right">
                <input type="text" id="suffix" name="suffix" class="form-control" placeholder="Enter Suffix">
                <div class="form-control-position">
                  <i class="icon-user"></i>
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
          </div>
          <div class="form-row">
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
          </div>
          <div class="form-row">
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
                  <i class="fa fa-heart"></i>
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
          <div class="form-group">
              <label for="department">Select Department</label>
              <select id="department" name="department" class="form-control" required>
                  <option value="" disabled selected>--Select Department--</option>
                  <option value="College">College</option>
                  <option value="Basic Ed">Basic Ed</option>
                  <option value="Employee">Employee</option>
              </select>
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
<script type="text/javascript"> let table = new DataTable('#myTable');</script>

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