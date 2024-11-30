<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // Check if the email and mobile number exist
    $sql = "SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        // Store email and mobile in session for next step
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_mobile'] = $mobile;
        header("Location: set_new_password.php"); // Redirect to new password setup page
        exit();
    } else {
        echo "<script>alert('Email or Mobile number is invalid');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../assets/css/app-style.css" rel="stylesheet"/>
    <style>
        #wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card-authentication1 {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body class="bg-theme bg-theme9">
<div id="wrapper">
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="card-title text-uppercase text-center py-3">Reset Password</div>
                <form method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email Address" required name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" required>
                    </div>
                    <button type="submit" class="btn btn-light btn-block" name="submit">Verify</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <p class="text-warning mb-0">Back to <a href="login.php">Login Page</a></p>
            
        </div>
    </div>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
