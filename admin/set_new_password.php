<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_mobile'])) {
    header("Location: forgot_password.php");
    exit();
}

if (isset($_POST['submit'])) {
    $newpassword = md5($_POST['newpassword']);
    $confirmpassword = md5($_POST['confirmpassword']);

    if ($newpassword === $confirmpassword) {
        $email = $_SESSION['reset_email'];
        $mobile = $_SESSION['reset_mobile'];

        // Update password in the database
        $sql = "UPDATE tbladmin SET Password=:newpassword WHERE Email=:email AND MobileNumber=:mobile";
        $query = $dbh->prepare($sql);
        $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->execute();

        // Clear session data and redirect with success message
        session_unset();
        session_destroy();
        echo "<script>alert('Your password has been changed successfully');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Passwords do not match');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || Set New Password</title>
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
                
                <div class="card-title text-uppercase text-center py-3">Set New Password</div>
                <form method="post">
                    <div class="form-group">
                        <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn btn-light btn-block" name="submit">Set Password</button>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
