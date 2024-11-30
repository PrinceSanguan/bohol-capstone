<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot_password.php');
    exit();
}

$message = "";
$error_message = "";

if (isset($_POST['reset'])) {
    $email = $_SESSION['reset_email'];
    $schoolId = $_SESSION['reset_schoolid'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    if ($newpassword !== $confirmpassword) {
        $error_message = "New Password and Confirm Password do not match!";
    } else {
        $newpassword_hashed = password_hash($newpassword, PASSWORD_BCRYPT);
        $con = "UPDATE tbluser SET Password = :newpassword WHERE Email = :email AND SchoolID = :schoolid";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':schoolid', $schoolId, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword_hashed, PDO::PARAM_STR);
        $chngpwd1->execute();

        session_destroy();
        $_SESSION['success_message'] = "Your password has been successfully changed.";
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="image/bnsc123.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: url('image/logo.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.5);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            height: 500px;
            width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(5px);
            position: relative;
            border: 1px solid blue;
            box-shadow: 0 0 20px rgba(0, 150, 255, 0.5);
        }

        .login-container {
            width: 100%;
            height: 75%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            backdrop-filter: blur(5px);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .logo-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }

        .school-name {
            color: #004aad;
            font-size: 60px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
            text-shadow: 3px 3px 3px rgba(255, 255, 255, 0.8);
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
            margin-top: 20px;
            width: 100%;
        }

        .input-group input {
            width: 100%;
            padding: 15px 40px 15px 35px;
            border: 1px solid #004aad;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.7);
            margin: 5px 0;
            font-size: 15px;
        }

        .icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #004aad;
        }

        .reset-button {
            width: 100%;
            padding: 12px;
            background: #004aad;
            color: #fff;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .reset-button:hover {
            background: #0066cc;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: absolute;
            top:0px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 80%;
            max-width: 300px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: absolute;
            top:0px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 80%;
            max-width: 300px;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="logo-header">
        <img src="image/mlogo.png" alt="School Logo" class="school-logo">
        <h2 class="school-name">BNSC</h2>
    </div>

    <div class="login-container">
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <form method="post" name="chngpwd" onsubmit="return valid();">
            <div class="input-group">
                <span class="icon">🔒</span>
                <input class="form-control" type="password" name="newpassword" placeholder="New Password" required="true"/>
            </div>
            <div class="input-group">
                <span class="icon">🔒</span>
                <input class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required="true"/>
            </div>
            <div id="js-error-message" class="error-message" style="display: none;">New Password and Confirm Password do not match!</div>
            <button type="submit" class="reset-button" name="reset">RESET</button>
        </form>
    </div>
</div>

<!-- JavaScript Validation without alert -->
<script type="text/javascript">
    function valid() {
        const newPassword = document.chngpwd.newpassword.value;
        const confirmPassword = document.chngpwd.confirmpassword.value;
        const errorMessage = document.getElementById('js-error-message');

        if (newPassword !== confirmPassword) {
            errorMessage.style.display = 'block';
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        errorMessage.style.display = 'none';
        return true;
    }
</script>



</body>
</html>
