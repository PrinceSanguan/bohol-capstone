<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is already logged in
if (isset($_SESSION['uid'])) {
    header('location:dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $schoolid = $_POST['SchoolID'];
    $password = md5($_POST['password']);
    
    // Check if school id and password are empty
    if (empty($schoolid) || empty($_POST['password'])) {
        $message = "All fields are required.";
    } else {
        $sql = "SELECT * FROM tbluser WHERE SchoolID=:SchoolID";
        $query = $dbh->prepare($sql);
        $query->bindParam(':SchoolID', $schoolid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            // School ID exists, now check the password
            if ($results[0]->Password === $password) {
                $_SESSION['uid'] = $results[0]->ID;
                $_SESSION['img'] = $results[0]->Photo;
                $_SESSION['login'] = $schoolid;
                header('location:dashboard.php');
                exit;
            } else {
                $message = "Wrong Password.";
            }
        } else {
            $message = "School ID is not registered.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="image/bnsc123.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <title>Scholarship Student Login Form</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
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
      padding-bottom: 0;
      border: 1px solid blue;
      box-shadow: 0 0 20px rgba(0, 150, 255, 0.5); /* Blue shadow for glow */
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
      margin-top: 10px;
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

    .input-group input:focus {
      outline: none;
      border-color: #0066cc;
    }

    .icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #004aad;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      cursor: pointer;
      color: #004aad;
    }

    .extra-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
      margin-top: 20px;
      margin-bottom: 25px;
    }

    .extra-options label {
      color: #333;
    }

    .forgot-password {
      color: #0066cc;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .login-button {
      width: 100%;
      padding: 12px;
      background: #004aad;
      color: #fff;
      border: none;
      border-radius: 20px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      margin-bottom: 15px;
    }

    .login-button:hover {
      background: #0066cc;
    }

    .return-home {
      display: block;
      color: #004aad; /* Blue color for the link */
      text-decoration: none;
      margin-top: 20px;
      font-size: 16px;
      text-align: center;
    }

    .return-home span {
      color: #ff6a00; /* Orange color for "Home Page" */
    }

    .return-home:hover {
      text-decoration: underline;
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
        <div id="message" style="
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
        ">
            <?php echo $message; ?>
        </div>
        <script>
            // Hide the message after 5 seconds
            setTimeout(function() {
                document.getElementById("message").style.display = "none";
            }, 3000);
        </script>
    <?php endif; ?>
    <div class="login-container">
      <form method="POST">
      <div class="input-group">
        <span class="icon">👤</span>
        <input type="text" name="SchoolID" placeholder="School ID" required>
      </div>

      <div class="input-group">
        <span class="icon">🔒</span>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
      </div>

      <div class="extra-options">
        <label>
          <input type="checkbox" onclick="togglePassword()"> Show Password
        </label>
        <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
      </div>

      <button type="submit" name="login" class="login-button">LOG IN</button>

      <a href="../index.php" class="return-home">Return to <span>Home Page</span></a>
    </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      passwordField.type = passwordField.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>