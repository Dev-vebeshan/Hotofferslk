<?php
session_start();
require_once 'db/connection.php';

if (isset($_SESSION['reset_mail']) && isset($_SESSION['type'])) {
    $reset_mail = $_SESSION['reset_mail'];
    $type=$_SESSION['type'];
} else {
    echo "<script>location.replace('forgot_password.php');</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/16x16 logo.png">
  <title>Reset Password</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
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
    button:disabled {
      background: #ccc;
      cursor: not-allowed;
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
    .password-requirements {
      list-style: none;
      padding: 0;
      margin-top: 10px;
    }
    .password-requirements li {
      color: #888;
      font-size: 14px;
    }
    .password-requirements .valid {
      color: green;
    }
    .password-requirements .invalid {
      color: red;
    }
    .password-match-status {
      margin-top: 10px;
      font-size: 14px;
      font-weight: bold;
    }
    .password-match-status.valid {
      color: green;
    }
    .password-match-status.invalid {
      color: red;
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm-password']);

        // Validate password on the server-side
        $regexUppercase = "/[A-Z]/";
        $regexLowercase = "/[a-z]/";
        $regexNumber = "/[0-9]/";
        $regexSpecialChar = "/[!@#$%^&*(),.?\":{}|<>]/";
        $minLengthReq = 8;
        $maxLengthReq = 20;

        $errors = [];

        if (!preg_match($regexUppercase, $password)) {
            $errors[] = "Password must include at least one uppercase letter.";
        }
        if (!preg_match($regexLowercase, $password)) {
            $errors[] = "Password must include at least one lowercase letter.";
        }
        if (!preg_match($regexNumber, $password)) {
            $errors[] = "Password must include at least one number.";
        }
        if (!preg_match($regexSpecialChar, $password)) {
            $errors[] = "Password must include at least one special character.";
        }
        if (strlen($password) < $minLengthReq || strlen($password) > $maxLengthReq) {
            $errors[] = "Password must be between 8 and 20 characters.";
        }
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            echo '<script>
              Swal.fire({
               text: "' . implode(' ', $errors) . '",
               icon: "error",
               confirmButtonText: "OK"
              });
            </script>';
        } else {
            
            if($type=="startup")
            {
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $sql = $con->prepare("UPDATE customer SET password = ?, modified =? WHERE email = ?");
                $sql->bind_param('sss', $hashpass,$current_time,$reset_mail);
    
                if ($sql->execute()) {
                    echo '<script>
                      Swal.fire({
                       text: "Password Successfully Changed",
                       icon: "success",
                       confirmButtonText: "OK"
                       }).then((result) => {
                            if (result.isConfirmed) {
                                 window.location.href = "login.php";
                             }
                         });
                     </script>';
                } else {
                    echo '<script>
                      Swal.fire({
                       text: "Password Not Changed",
                       icon: "error",
                       confirmButtonText: "OK"
                       });
                     </script>';
                }
 
            }
            else
            {
                if($type=="enterprise")
                {
                    $hashpass = password_hash($password, PASSWORD_DEFAULT);
                    $sql = $con->prepare("UPDATE user SET password = ?, updated_date =? WHERE mail = ?");
                    $sql->bind_param('sss', $hashpass,$current_time,$reset_mail);
        
                    if ($sql->execute()) {
                        echo '<script>
                          Swal.fire({
                           text: "Password Successfully Changed",
                           icon: "success",
                           confirmButtonText: "OK"
                           }).then((result) => {
                                if (result.isConfirmed) {
                                     window.location.href = "login.php";
                                 }
                             });
                         </script>';
                    } else {
                        echo '<script>
                          Swal.fire({
                           text: "Password Not Changed",
                           icon: "error",
                           confirmButtonText: "OK"
                           });
                         </script>';
                    }
                }
            }
        }
    }
    ?>

    <div class="form-container">
        <div class="form-header">
            <a href="index.php">
            <img src="./assets/images/Logo_1.png" alt="Company Logo"></a>
            <h1>Reset Your Password</h1>
        </div>
        <form id="reset-password-form" method="POST">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="password" placeholder="Enter new password" required minlength="8" maxlength="20">

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required minlength="8" maxlength="20">

            <button type="submit" id="reset-btn" disabled>
                <span id="loginText">Reset Password</span>
                <span id="spinner" class="loading-spinner ml-2"></span>
            </button>

            <ul class="password-requirements" id="password-requirements">
                <li id="uppercase" class="invalid">At least one uppercase letter</li>
                <li id="lowercase" class="invalid">At least one lowercase letter</li>
                <li id="number" class="invalid">At least one number</li>
                <li id="special-char" class="invalid">At least one special character</li>
                <li id="min-length" class="invalid">Minimum 8 characters</li>
            </ul>

            <div class="password-match-status" id="password-match-status"></div>
        </form>
    </div>

    <script>
        const newPassword = document.getElementById('new-password');
        const confirmPassword = document.getElementById('confirm-password');
        const passwordRequirements = document.getElementById('password-requirements');
        const passwordMatchStatus = document.getElementById('password-match-status');
        const resetBtn = document.getElementById('reset-btn');

        const uppercase = document.getElementById('uppercase');
        const lowercase = document.getElementById('lowercase');
        const number = document.getElementById('number');
        const specialChar = document.getElementById('special-char');
        const minLength = document.getElementById('min-length');

        const regexUppercase = /[A-Z]/;
        const regexLowercase = /[a-z]/;
        const regexNumber = /[0-9]/;
        const regexSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;
        const minLengthReq = 8;

        function validatePassword() {
            const password = newPassword.value;

            const hasUppercase = regexUppercase.test(password);
            const hasLowercase = regexLowercase.test(password);
            const hasNumber = regexNumber.test(password);
            const hasSpecialChar = regexSpecialChar.test(password);
            const hasMinLength = password.length >= minLengthReq;

            uppercase.classList.toggle('valid', hasUppercase);
            lowercase.classList.toggle('valid', hasLowercase);
            number.classList.toggle('valid', hasNumber);
            specialChar.classList.toggle('valid', hasSpecialChar);
            minLength.classList.toggle('valid', hasMinLength);

            uppercase.classList.toggle('invalid', !hasUppercase);
            lowercase.classList.toggle('invalid', !hasLowercase);
            number.classList.toggle('invalid', !hasNumber);
            specialChar.classList.toggle('invalid', !hasSpecialChar);
            minLength.classList.toggle('invalid', !hasMinLength);

            resetBtn.disabled = !(hasUppercase && hasLowercase && hasNumber && hasSpecialChar && hasMinLength);
        }

        function checkPasswordMatch() {
            if (newPassword.value !== confirmPassword.value) {
                passwordMatchStatus.textContent = "Passwords do not match";
                passwordMatchStatus.classList.add('invalid');
                passwordMatchStatus.classList.remove('valid');
                resetBtn.disabled = true;
            } else {
                passwordMatchStatus.textContent = "Passwords match";
                passwordMatchStatus.classList.add('valid');
                passwordMatchStatus.classList.remove('invalid');
                validatePassword();
            }
        }

        newPassword.addEventListener('input', () => {
            validatePassword();
            checkPasswordMatch();
        });

        confirmPassword.addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>
