<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['aid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $schemename = $_POST['schemename'];
    $yearofsch = $_POST['yearofsch'];
    $lastdate = $_POST['lastdate'];
    $schfee = $_POST['schfee'];
    $department = $_POST['department'];
    $requirements = isset($_POST['requirements']) ? $_POST['requirements'] : []; // Ensure it's an array
    $eid = $_GET['editid'];
    $imagePath = null;

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = true;

        // Validate image
        if (!getimagesize($_FILES["image"]["tmp_name"])) {
            echo '<script>alert("File is not an image.")</script>';
            $uploadOk = false;
        }
        if ($_FILES["image"]["size"] > 500000) {
            echo '<script>alert("Sorry, your file is too large.")</script>';
            $uploadOk = false;
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
            $uploadOk = false;
        }
        if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
        }
    }

    // Process requirements
    $requirementNames = [];
    if (!empty($requirements)) {
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
    }
    $requirementsString = implode(', ', $requirementNames);

    // Prepare SQL query
    $sql = "UPDATE tblscheme 
            SET SchemeName=:schemename, 
                Yearofscholarship=:yearofsch, 
                LastDate=:lastdate, 
                Scholarfee=:schfee, 
                department=:department, 
                Requirements=:requirements";
    if ($imagePath) {
        $sql .= ", Image=:image";
    }
    $sql .= " WHERE ID=:eid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':schemename', $schemename, PDO::PARAM_STR);
    $query->bindParam(':yearofsch', $yearofsch, PDO::PARAM_STR);
    $query->bindParam(':lastdate', $lastdate, PDO::PARAM_STR);
    $query->bindParam(':schfee', $schfee, PDO::PARAM_STR);
    $query->bindParam(':department', $department, PDO::PARAM_STR);
    $query->bindParam(':requirements', $requirementsString, PDO::PARAM_STR);
    if ($imagePath) {
        $query->bindParam(':image', $imagePath, PDO::PARAM_STR);
    }
    $query->bindParam(':eid', $eid, PDO::PARAM_INT);
    $query->execute();

    echo '<script>alert("Scheme detail has been updated"); window.location.href="manage-scheme.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scholarship Management System || Update Scheme</title>
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
</style>

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
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <div class="card-title">Edit Scholarship</div>
              <hr>
              <form method="post" enctype="multipart/form-data">
                <?php
                $eid = $_GET['editid'];
                $sql = "SELECT * FROM tblscheme WHERE ID=:eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                        <div class="form-group">
                            <label for="schemename">Name of Scholarship</label>
                            <input type="text" class="form-control" id="schemename" name="schemename" value="<?php echo htmlentities($row->SchemeName); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="yearofsch">Year of Scholarship</label>
                            <input type="text" class="form-control" id="yearofsch" name="yearofsch" value="<?php echo htmlentities($row->Yearofscholarship); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="lastdate">Last Date</label>
                            <input type="date" class="form-control" id="lastdate" name="lastdate" value="<?php echo htmlentities($row->LastDate); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="schfee">Scholarship Tuition Fee</label>
                            <textarea class="form-control" id="schfee" name="schfee" required><?php echo htmlentities($row->Scholarfee); ?></textarea>
                        </div>

                        <div class="form-group">
                          <label for="department">Select Department</label>
                          <select id="department" name="department" class="form-control" required>
                              <option value="" disabled>--Select Department--</option>
                              <option value="College" <?php echo ($row->department == 'College') ? 'selected' : ''; ?>>College</option>
                              <option value="Basic Ed" <?php echo ($row->department == 'Basic Ed') ? 'selected' : ''; ?>>Basic Ed</option>
                              <option value="Employee" <?php echo ($row->department == 'Employee') ? 'selected' : ''; ?>>Employee</option>
                          </select>
                        </div>

                        <div class="form-group">
                            <label for="requirements">Select Requirements</label>
                            <select id="docreq" name="requirements[]" class="form-control" multiple="multiple" required>
                                <?php
                                // Fetch scholarship requirements from the database
                                $reqQuery = "SELECT * FROM scholarship_requirements";
                                $reqData = $dbh->query($reqQuery);
                                while ($reqRow = $reqData->fetch(PDO::FETCH_ASSOC)) {
                                    // Check if the requirement is already associated with the scheme
                                    $selected = (strpos($row->Requirements, $reqRow['requirement_name']) !== false) ? 'selected' : '';
                                    echo "<option value='{$reqRow['id']}' $selected>{$reqRow['requirement_name']}</option>";
                                }
                                ?>
                            </select>
                            <button type="button" class="btn btn-secondary mt-2" data-toggle="modal" data-target="#addRequirementModal">Add Requirement</button>
                        </div>

                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small>Leave blank if you don't want to change the image.</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-light px-5" name="submit">
                                <i class="icon-lock"></i> Update
                            </button>
                        </div>
                <?php }
                } ?>
              </form>
            </div>
          </div>
        </div>
      </div><!--End Row-->
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
  <?php include_once('includes/footer.php'); ?>


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