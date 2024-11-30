<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {
    $img = $_SESSION['img'];
    $user_department = $_SESSION['department']; // Fetching user's department from session

    if (isset($_POST['submit'])) {
        $appnum = mt_rand(100000000, 999999999);
        $schemeid = intval($_GET['viewid']);
        $uid = $_SESSION['uid'];
        $doc = $_FILES["reqdoc"]["name"];

        $extension1 = substr($doc, strlen($doc) - 4, strlen($doc));
        $allowed_extensions1 = array("docx", ".doc", ".pdf");

        if (!in_array($extension1, $allowed_extensions1)) {
            echo "<script>alert('File has Invalid format. Only docs / doc/ pdf format allowed');</script>";
        } else {
            $doc = md5($doc) . time() . "." . $extension1;
            move_uploaded_file($_FILES["reqdoc"]["tmp_name"], "document/" . $doc);

            // Check if the user has already applied for this scholarship
            $query1 = "SELECT ID FROM tblapply WHERE UserID=:uid AND SchemeId=:schemeid";
            $query1 = $dbh->prepare($query1);
            $query1->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query1->bindParam(':schemeid', $schemeid, PDO::PARAM_STR);
            $query1->execute();

            if ($query1->rowCount() > 0) {
                echo "<script>alert('Already Applied for this scholarship');</script>";
                echo "<script>window.location.href ='views-scheme.php'</script>";
            } else {
                // Insert the application
                $sql = "INSERT INTO tblapply(SchemeId, ApplicationNumber, UserID, DocReq) VALUES(:schemeid, :appnum, :uid, :doc)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':schemeid', $schemeid, PDO::PARAM_STR);
                $query->bindParam(':appnum', $appnum, PDO::PARAM_STR);
                $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                $query->bindParam(':doc', $doc, PDO::PARAM_STR);
                $query->execute();

                $LastInsertId = $dbh->lastInsertId();
                if ($LastInsertId > 0) {
                    echo '<script>alert("Your application has been sent successfully. Application Number is ' . $appnum . '")</script>';
                    echo "<script>window.location.href ='views-scheme.php'</script>";
                } else {
                    echo '<script>alert("Something Went Wrong. Please try again")</script>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || View Scheme</title>
    <!-- Include your existing CSS files -->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/sidebar-menu.css" rel="stylesheet" />
    <link href="../assets/css/app-style.css" rel="stylesheet" />
</head>
<style>
    .custom-input {
        border-radius: 0.5rem;
        border: 1px solid #007bff;
        box-shadow:  0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        border-color: #0056b3;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    input[type="file"] {
        padding: 5px;
        border-radius: 0.5rem;
        border: 1px solid #007bff;
        transition: all 0.3s ease;
    }

    input[type="file"]:focus {
        border-color: #0056b3;
    }

    .form-control {
        color: black !important;
    }

    .form-label {
        color: #333;
        font-weight: bold;
    }

    .modal-header {
        background-color: #007bff;
        color: #fff;
    }

    .modal-footer {
        background-color: #f1f1f1;
    }

    .modal-body {
        background-color: #ffffff;
        padding: 20px;
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">View Scholarship Details</h5>
                                <?php
                                $vid = $_GET['viewid'];
                                $sql = "SELECT * FROM tblscheme WHERE ID = :vid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':vid', $vid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) { ?>
                                        <table border="1" class="table table-bordered">
                                            <tr>
                                                <th scope>Name of Scholarship</th>
                                                <td><?php echo $row->SchemeName; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Year of Scholarship</th>
                                                <td><?php echo $row->Yearofscholarship; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Last Date</th>
                                                <td><?php echo $ldate = $row->LastDate; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Requirements Scholarship</th>
                                                <td style="word-wrap: break-all;"><?php echo $row->Requirements; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Scholarship Tuition Fee</th>
                                                <td><?php echo $row->Scholarfee; ?></td>
                                            </tr>
                                        </table>
                                <?php }
                                } ?>

                                <br>
                                <div class="table-responsive">
                                    <?php
                                    $cdate = date('Y-m-d');
                                    if ($cdate <= $ldate) {
                                        // Check if the user's department matches the scholarship's department
                                        if ($row->Department == $user_department) { ?>
                                            <p align="center">
                                                <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Apply Now</button>
                                            </p>
                                        <?php } else { ?>
                                            <p style="color:red; font-size: 18px;">***** You are not eligible to apply for this scholarship.</p>
                                        <?php }
                                    } else { ?>
                                        <p style="color:red; font-size: 18px;">***** Submission date is over</p>
                                    <?php } ?>

                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Apply Now</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" name="submit" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="reqdoc" class="form-label">Upload Required Doc:</label>
                                                                <input type="file" name="reqdoc" class="form-control custom-input" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--End Row-->

                <div class="overlay toggle-menu"></div>
            </div><!-- End container-fluid-->
        </div><!--End content-wrapper-->

        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

        <?php include_once('includes/footer.php'); ?>
    </div><!--End wrapper-->

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/app-script.js"></script>
</body>
</html>
<?php } ?>