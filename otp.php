<?php
session_start();
require_once 'db/connection.php';

$error="";
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
  <title>OTP Verification</title>
  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--Sweet Alert CSS and JS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
    .timer {
      text-align: center;
      font-size: 18px;
      color: #FF0000;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .form-footer a {
      text-decoration: none;
      color: #ff5713;
    }
    .form-footer a:hover {
      color: #f97225;
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
    <?php
    if(isset($_SESSION['reset_mail']) && isset($_SESSION['type']))
  {
    $reset_mail=$_SESSION['reset_mail'];
    $user=$_SESSION['type'];
    
    if($_SERVER['REQUEST_METHOD']==='POST')
  {
    $otp=trim($_POST['otp']);
    
    if($user=="startup")
    {
        $check_otp=$con->prepare("SELECT * FROM customer WHERE email=? AND otp_no=?");
        $check_otp->bind_param('ss',$reset_mail,$otp);
        $check_otp->execute();
        $result=$check_otp->get_result();
        
        if($result->num_rows > 0)
            {
                echo '<script>
                                     Swal.fire({
                                         text: "OTP Successfully Verified",
                                         icon: "success",
                                         confirmButtonText: "OK"
                                     }).then((result) => {
                                         if (result.isConfirmed) {
                                             window.location.href = "reset_password.php";
                                         }
                                     });
                                 </script>';
            }
            else
            {
                $error='<div class="error-box">Invalid OTP...</div>';
            }
    }
    else
    {
        if($user=="enterprise")
        {
            $business="Business user";
            $check_otp=$con->prepare("SELECT * FROM user WHERE mail=? AND role=? AND otp_no=?");
            $check_otp->bind_param('sss',$reset_mail,$business,$otp);
            $check_otp->execute();
            $result=$check_otp->get_result();
            
            if($result->num_rows > 0)
                {
                    echo '<script>
                                         Swal.fire({
                                             text: "OTP Successfully Verified",
                                             icon: "success",
                                             confirmButtonText: "OK"
                                         }).then((result) => {
                                             if (result.isConfirmed) {
                                                 window.location.href = "reset_password.php";
                                             }
                                         });
                                     </script>';
                }
                else
                {
                    $error='<div class="error-box">Invalid OTP...</div>';
                }
        }
    }
    
    
    
    
    
    
    
    
    
}
    
    
}
else
{
    echo "<script>location.replace('forgot_password.php'); </script>";
}
?>

  <div class="form-container">
    <div class="form-header">
        <a href="index.php">
      <img src="./assets/images/Logo_1.png" alt="Company Logo"></a>
      <h1>OTP Verification</h1>
    </div>
    <form id="otp-form" method="POST">
      <p>We’ve sent an OTP to your email. Please enter it below.</p>
      <?php echo $error; ?>

      <input type="text" id="otp" name="otp" placeholder="Enter your OTP" required>
      <button type="submit" id="loginButton">
          <span id="loginText">Verify OTP</span>
          <span id="spinner" class="loading-spinner ml-2"></span> <!-- Initially hidden spinner -->
     </button>

      <div class="timer" id="timer">00:60</div> <!-- Timer Display -->

    </form>
    <div class="form-footer">
      <a href="otp_mail_function.php" id="resend-otp">Resend OTP</a>
    </div>
  </div>

  <script>
    // Get stored time from localStorage if available, else start with 60 seconds
    let timeLeft = localStorage.getItem('otpTimeLeft') ? parseInt(localStorage.getItem('otpTimeLeft')) : 60;
    const timerDisplay = document.getElementById('timer');
    const resendLink = document.getElementById('resend-otp');

    // Function to update the timer display
    function updateTimer() {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;
      seconds = seconds < 10 ? '0' + seconds : seconds; // Add leading zero if needed
      timerDisplay.textContent = `${minutes}:${seconds}`;
      timeLeft--;

      // When time is up
      if (timeLeft < 0) {
        clearInterval(timerInterval);
        timerDisplay.textContent = 'Expired';
        timerDisplay.style.color = '#FF0000'; // Change link color
        resendLink.style.pointerEvents = 'auto'; // Enable resend OTP
        resendLink.style.color = '#ff5713'; // Change link color
      }

      // Store the remaining time in localStorage
      localStorage.setItem('otpTimeLeft', timeLeft);
    }

    // Start the countdown
    const timerInterval = setInterval(updateTimer, 1000);

    // Enable "Resend OTP" after the timer expires
    resendLink.style.pointerEvents = 'none'; // Disable initially
    resendLink.style.color = '#ccc'; // Gray out the link
    resendLink.addEventListener('click', function() {
      // Placeholder for resend OTP action (e.g., AJAX request)
      alert('Resending OTP...');
      timeLeft = 60; // Reset the timer
      clearInterval(timerInterval);
      setInterval(updateTimer, 1000); // Restart the countdown
      resendLink.style.pointerEvents = 'none'; // Disable the link
      resendLink.style.color = '#ccc'; // Gray out the link

      // Save the reset time to localStorage
      localStorage.setItem('otpTimeLeft', timeLeft);
    });
  </script>
  
  <script>
    // JavaScript to handle button loading
    document.getElementById('otp-form').addEventListener('submit', function (e) {
      
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
