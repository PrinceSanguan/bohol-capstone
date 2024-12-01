<?php
session_start();
error_reporting(E_ALL); // Enable all error reporting
ini_set('display_errors', 1); // Display errors on the screen

include('includes/dbconnection.php');
if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $schemename = $_POST['schemename'];
        $yearofsch = $_POST['yearofsch'];
        $lastdate = $_POST['lastdate'];
        $schfee = $_POST['schfee'];
        $deparment = $_POST['department'];
        $requirements = isset($_POST['requirements']) ? $_POST['requirements'] : []; // Ensure it's an array

        // Handle the image upload
        $target_dir = "uploads/"; // Define the upload directory
        $target_file = $target_dir . basename($_FILES["image"]["name"]); // Full path for uploaded image
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if image file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo '<script>alert("File is not an image.")</script>';
            $uploadOk = 0;
        }

        // Check file size (optional)
        if ($_FILES["image"]["size"] > 500000) {
            echo '<script>alert("Sorry, your file is too large.")</script>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<script>alert("Sorry, your file was not uploaded.")</script>';
        } else {
            // If everything is ok, try to upload the file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Get requirement names instead of IDs
                $requirementNames = [];
                foreach ($requirements as $reqId) {
                    $reqQuery = "SELECT requirement_name FROM scholarship_requirements WHERE id = :reqId";
                    $reqStmt = $dbh->prepare($reqQuery);
                    $reqStmt->bindParam(':reqId', $reqId, PDO::PARAM_INT);
                    $reqStmt->execute();
                    $reqRow = $reqStmt->fetch(PDO::FETCH_ASSOC);
                    if ($reqRow) {
                        $requirementNames[] = $reqRow['requirement_name'];
                    }
                } 
                $requirementsString = implode(', ', $requirementNames); // Create a comma-separated string

                // Insert into database
                $sql = "INSERT INTO tblscheme(SchemeName, Yearofscholarship, LastDate, Scholarfee, Image, Requirements, department)
        VALUES(:schemename, :yearofsch, :lastdate, :schfee, :image, :requirements, :department)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':schemename', $schemename, PDO::PARAM_STR);
                $query->bindParam(':yearofsch', $yearofsch, PDO::PARAM_STR);
                $query->bindParam(':lastdate', $lastdate, PDO::PARAM_STR);
                $query->bindParam(':schfee', $schfee, PDO::PARAM_STR);
                $query->bindParam(':image', $target_file, PDO::PARAM_STR); // Save image path
                $query->bindParam(':requirements', $requirementsString, PDO::PARAM_STR); // Save requirement names
                $query->bindParam(':department', $_POST['department'], PDO::PARAM_STR);
                
                // Execute the query
                if ($query->execute()) {
                    $LastInsertId = $dbh->lastInsertId();
                    if ($LastInsertId > 0) {
                        echo '<script>alert("Scheme detail has been added.")</script>';
                        echo "<script>window.location.href ='add-scheme.php'</script>";
                    } else {
                        echo '<script>alert("Something Went Wrong. Please try again")</script>';
                    }
                } else {
                    echo '<script>alert("Failed to execute the query.")</script>';
                }
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
            }
        }
    }

    // Handle adding new scholarship requirement
    if (isset($_POST['add_requirement'])) {
        $new_requirement = $_POST['new_requirement'];
        $sql = "INSERT INTO scholarship_requirements (requirement_name) VALUES (:requirement_name)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':requirement_name', $new_requirement, PDO::PARAM_STR);
        
        // Execute the query and check for success
        if ($query->execute()) {
            echo '<script>alert("New requirement added successfully.")</script>';
        } else {
            echo '<script>alert("Failed to add new requirement.")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scholarship Management System || Add Scheme</title>
  <!-- Include your existing CSS files -->
  <link href="image/bnsc123.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <link href="../assets/css/pace.min.css" rel="stylesheet"/>
  <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="../assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <link href="../assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <link href="../assets/css/sidebar-menu.css" rel="stylesheet"/>
  <link href="../assets/css/app-style.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../assets/css/custom-form-style.css" rel="stylesheet"/>
</head>
<style>  
/* Existing CSS */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: black !important;
}

/* Change font color of dropdown options */
.select2-container--default .select2-results__option {
    color: black;
}

/* Custom styles for the modal */
#addRequirementModal .modal-content {
    background-color: #343a40;
    color: white; /* Optional: Change text color for better contrast */
}
</style>


<body class="bg-theme bg-theme9">
  <!-- Loader -->
  <div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
      <div class="loader-wrapper-inner">
        <div class="loader"></div>
      </div>
    </div>
  </div>

  <!-- Start wrapper-->
  <div id="wrapper">
    <!-- Sidebar and Header -->
    <?php include_once('includes/sidebar.php');?>
    <?php include_once('includes/header.php');?>

    <div class="clearfix"></div>
    
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row mt-3">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body form-container">
                <div class="card-title">Add Scholarship</div>
                <hr>
                <form method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="schemename">Name of Scholarship</label>
                    <input type="text" class="form-control" id="schemename" name="schemename" required>
                  </div>
  
                  <div class="form-group">
                    <label for="yearofsch">Year of Scholarship</label>
                    <input type="text" class="form-control" id="yearofsch" name="yearofsch" required>
                  </div>
  
                  <div class="form-group">
                    <label for="lastdate">Last Date</label>
                    <input type="date" class="form-control" id="lastdate" name="lastdate" required>
                  </div>

                  <div class="form-group">
                    <label for="schfee">Scholarship Tuition Fee</label>
                    <textarea class="form-control" id="schfee" name="schfee" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="requirements">Select Requirements</label>
                    <select id="docreq" name="requirements[]" class="form-control" multiple="multiple" required>
                      <?php
                      // Fetch scholarship requirements from the database
                      $reqQuery = "SELECT * FROM scholarship_requirements";
                      $reqData = $dbh->query($reqQuery);
                      while ($reqRow = $reqData->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value='{$reqRow['id']}'>{$reqRow['requirement_name']}</option>";
                      }
                      ?>
                    </select>
                    <button type="button" class="btn btn-secondary mt-2" data-toggle="modal" data-target="#addRequirementModal">Add Requirement</button>
                  </div>
                  <div class="form-group">
                    <label for="department">Select Department</label>
                    <select id="department" name="department" class="form-control" required>
                      <option value="College">College</option>
                      <option value="Basic Ed">Basic Ed</option>
                      <option value="Employee">Employee</option>
                    </select>
                  </div>

                      
                  <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-light px-5" name="submit">
                        <i class="icon-lock"></i> Add
                    </button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div><!--End Row-->
        
        <!-- Modal for Adding New Requirement -->
        <div class="modal fade" id="addRequirementModal" tabindex="-1" role="dialog" aria-labelledby="addRequirementModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addRequirementModalLabel">Add New Requirement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post">
                  <div class="form-group">
                    <label for="new_requirement">Requirement Name</label>
                    <input type="text" class="form-control" id="new_requirement" name="new_requirement" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_requirement">Add Requirement</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!--start overlay-->
        <div class="overlay toggle-menu"></div>
        <!--end overlay-->
      </div><!-- End container-fluid-->
    </div><!--End content-wrapper-->
    
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top">
      <i class="fa fa-angle-double-up"></i>
    </a>
    <!--End Back To Top Button-->
    
    <!-- Footer -->
    <?php include_once('includes/footer.php');?>

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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $("#docreq").select2({
      placeholder: "Select requirements",
      allowClear: true
    });
  </script>
</body>
</html>
<?php } ?>
