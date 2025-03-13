<?php
session_start();
require_once 'db/connection.php';
$error = "<p>Please enter your registered email address. We'll send you an OTP to reset your password.</p>";

if(isset($_GET['user']))
{
    $user=$_GET['user'];
    
    if($user=="startup" || $user=="enterprise")
    {
        if($_SERVER['REQUEST_METHOD']==='POST')
        {
            $email=mysqli_real_escape_string($con,$_POST['email']);
            $status="active";
            
            if($user=="startup")
            {
              $check_mail=$con->prepare("SELECT * FROM customer WHERE email =? AND status=? ");
              $check_mail->bind_param('ss',$email,$status);
              $check_mail->execute();
              $result=$check_mail->get_result();
              
               if($result->num_rows > 0)
              {
                    $row=$result->fetch_assoc();
                    $_SESSION['reset_mail']=$email;
                    $_SESSION['name']=$row['name'];
                    $_SESSION['type']=$user;
                
                include('otp_mail_function.php');
            
              }
              else
              {
                    $error='<div class="error-box">Invalid Email...</div>';
              }
            }
            else
            {
                    if($user=="enterprise")
                    {
                      $business="Business user";
                      $check_mail=$con->prepare("SELECT * FROM user WHERE mail =? AND role=? AND status=? ");
                      $check_mail->bind_param('sss',$email,$business,$status);
                      $check_mail->execute();
                      $result=$check_mail->get_result();
                      
                       if($result->num_rows > 0)
                      {
                            $row=$result->fetch_assoc();
                            $_SESSION['reset_mail']=$email;
                            $_SESSION['name']=$row['name'];
                            $_SESSION['type']=$user;
                        
                        include('otp_mail_function.php');
                    
                      }
                      else
                      {
                            $error='<div class="error-box">Invalid Email...</div>';
                      }
                   }
            }
        }
    }
    else
    {
        echo "<script> location.replace(login.php); </script>";
    }
    
}
else
{
    echo "<script> location.replace(login.php); </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/16x16 logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Forgot Password</title>
  <style>
    body {
      font-family: "Poppins", serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #f97225, #ff5713);
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
   .error-box{
    padding: 4px;
    margin-bottom:4px;
    font-size:16px;
    font-weight:bold;
    text-align:center;
    color:red;
    background-color:lightred;
    border:none;
    border-radius:15px;    
    }
    
    .form-container {
      background: #fff;
      border-radius: 10px;
      padding: 30px 40px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }
    .form-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-header img {
      max-width: 150px;
      margin-bottom: 10px;
    }
    h1 {
      margin-bottom: 20px;
      color: #444;
      font-size: 24px;
    }
    label, p {
      display: block;
      margin-bottom: 8px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: #f97225;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }
    button:hover {
      background: #ff5713;
    }
    .form-footer {
      text-align: center;
      margin-top: 10px;
    }
    .form-footer a {
      color: #f97225;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    .form-footer a:hover {
      color: #ff5713;
    }
    
    .loading-spinner {
      border: 2px solid #f3f3f3;
      border-radius: 50%;
      border-top: 2px solid #ff5713;
      width: 16px;
      height: 16px;
      animation: spin 1s linear infinite;
      visibility: hidden; /* Initially hidden */
      position: absolute;
    }
    
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <div class="form-header">
        <a href="index.php">
      <img src="  ./assets/images/Logo_1.png" alt="Company Logo"></a>
      <h1>Forgot Password</h1>
    </div>
    <form id="forgot-password-form" method="POST">
     <?php echo $error; ?>
      
      <input type="email" id="email" name="email" placeholder="Enter your email" required>
      <button type="submit" id="loginButton">
          <span id="loginText">Send OTP</span>
          <span id="spinner" class="loading-spinner ml-2"></span> <!-- Initially hidden spinner -->
      </button>
    </form>
    <div class="form-footer">
      <a href="login.php">Back to Login</a>
    </div>
  </div>

<script>
    // JavaScript to handle button loading
    document.getElementById('forgot-password-form').addEventListener('submit', function (e) {
      e.preventDefault(); // Prevent form submission to show loading spinner
      const loginButton = document.getElementById('loginButton');
      const loginText = document.getElementById('loginText');
      const spinner = document.getElementById('spinner');
      
      // Show the spinner and disable the button
      loginText.style.visibility = "hidden"; // Hide the text
      spinner.style.visibility = "visible"; // Show the spinner
      loginButton.disabled = true;

      // Simulate a 3-second delay
      setTimeout(() => {
        this.submit(); // Submit the form after the delay
      }, 3000);

    });
</script>

</body>
</html>
