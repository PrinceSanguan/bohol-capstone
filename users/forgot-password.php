<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Step 1: Verify email and school ID
$message = ""; // Initialize message variable
if (isset($_POST['verify'])) {
    $email = $_POST['email'];
    $schoolId = $_POST['schoolid'];

    // Check if the email and school ID are valid
    $sql = "SELECT Email FROM tbluser WHERE Email = :email AND SchoolID = :schoolid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':schoolid', $schoolId, PDO::PARAM_STR);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        $_SESSION['reset_email'] = $email; // Store email in session for the next step
        $_SESSION['reset_schoolid'] = $schoolId; // Store school ID in session
        header('Location: reset_password.php'); // Redirect to password reset page
        exit();
    } else {
        $message = "Email ID or School ID is invalid"; // Set message for invalid input
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarship Management System || Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .verify-button {
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

        .verify-button:hover {
            background: #0066cc;
        }

        .return-home {
            display: block;
            color: #004aad; /* Blue color for the link */
            text-decoration: none;
            margin-top: 50px;
            font-size: 16px;
            text-align: center;
        }

        .return-home span {
            color: #ff6a00; /* Orange color for "Home Page" */
        }

        .return-home:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            padding: 10px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: absolute;
            top: 125px;
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
    
    <?php if (!empty($message)): ?>
        <div class="error-message" id="error-message">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <div class="login-container">
        <form method="post">
            <div class="input-group">
                <span class="icon">👤</span>
                <input type="text" name="schoolid" placeholder="School ID" required>
            </div>

            <div class="input-group">
                <span class="icon">✉️</span>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <button type="submit" class="verify-button" name="verify">Verify</button>
        </form>

        <a href="login.php" class="return-home">Return to <span>Home Page</span></a>
    </div>
</div>

<script>
    // Hide the error message after 3 seconds
    setTimeout(function() {
        const errorMessage = document.getElementById("error-message");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 3000);
</script>

</body>
</html>