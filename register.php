<?php
session_start();
require_once 'db/connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Your Account | Join HotOffers.lk</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Sign up on HotOffers.lk to start saving on your favorite products and services. Join now to get access to exclusive discounts and personalized offers!">
   <meta name="keywords" content="register, sign up, create account, HotOffers.lk, exclusive discounts">
   <meta name="author" content="HotOffers.lk">
  
  <link rel="icon" href="assets/images/192x192 logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  
   <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--Sweet Alert CSS and JS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
        body {
      font-family: "Poppins", serif;
      margin: 0;
      padding: 20px;
      background: linear-gradient(to right, #f97225, #ff5713);
      color: #333;
    }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            color: black;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .nav-tabs .nav-link {
            color: #f97225;
            font-weight: bold;
        }

        .nav-tabs .nav-link.active {
            background-color: #f97225;
            color: white;
        }

        .form-control:focus {
            border-color: #ff5713;
            box-shadow: 0 0 5px rgba(72, 133, 237, 0.5);
        }

        .btn-primary {
            background-color: #f97225;
            border-color: #f97225;
        }

        .btn-primary:hover {
            background-color: #ff5713;
            border-color: #ff5713;
        }

        .tab-content {
            padding: 15px;
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
        }

        .invalid-feedback {
            display: block;
        }
        
        img {
      max-width: 150px;
      margin-bottom: 5px;
    }
    
 .strength-meter {
            height: 10px;
            border-radius: 5px;
            margin-top: 8px;
        }

        #password-strength {
            width: 100%;
            background-color: #f4f4f4;
        }

        #password-strength .strength-bar {
            height: 100%;
            border-radius: 5px;
            width: 0;
        }

        #confirm-password-message {
            color: red;
            font-size: 14px;
            display: none;
        }

        #submit-btn:disabled {
            background-color: #ccc;
            color: #fff;
            cursor: not-allowed;
        }

        #submit-btn:enabled {
            background-color: #f97225;
            color: white;
            cursor: pointer;
        }
        
        .password-strength-info {
      margin-top: 10px;
      font-size: 0.9rem;
      color: #6c757d;
    }
    .strength-indicator-bar {
      height: 8px;
      margin-top: 10px;
      border-radius: 4px;
    }
    .strength-indicator-bar.weak {
      background: #dc3545;
    }
    .strength-indicator-bar.medium {
      background: #ffc107;
    }
    .strength-indicator-bar.strong {
      background: #28a745;
    }
    .submit-password-btn {
      width: 100%;
      margin-top: 20px;
    }
    .error-message {
      color: #dc3545;
      font-size: 0.9rem;
      margin-top: 5px;
    }
    
    
    .form-footer {
      text-align: center;
      margin-top: 20px;
    }
    .form-footer a {
      color: #f97225;
      text-decoration: none;
      font-weight: bold;
    }
    .form-footer a:hover {
      color: #ff5713;
      text-decoration: underline;
    }

    </style>
</head>

<body>
    
    <?php
    
    if(isset($_POST['customer']))
    {
        $customerName=trim($_POST['customerName']);
        $customerEmail=mysqli_real_escape_string($con,$_POST['customerEmail']);
        $customerPhone=trim($_POST['customerPhone']);       
        $city=trim($_POST['city']);
        $address=trim($_POST['address']);
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm-password'];
        $role="customer";
        
        $status = "inactive";
        $hashpass = password_hash($password, PASSWORD_DEFAULT);
        
        $check_mail = $con->prepare("SELECT * FROM customer WHERE email=?");
        $check_mail->bind_param('s', $customerEmail);
        $check_mail->execute();
        $result = $check_mail->get_result();
        
        if ($result->num_rows > 0) {
        echo '<script>
                Swal.fire({
                 text: "This email is already registered",
                 icon: "error",
                 confirmButtonText: "OK"
                 }).then((result) => {
                      if (result.isConfirmed) {
                           window.location.href = "register.php";
                      }
                });
              </script>';
    }
    else
    {
        $sql = $con->prepare("INSERT INTO customer(name, email, password, phone, city, address, status, created, modified) VALUES(?, ?, ?, ?, ?, ?,?,?,?)");
        $sql->bind_param('sssssssss', $customerName, $customerEmail, $hashpass, $customerPhone, $city, $address, $status,$current_time,$current_time);
        
        if ($sql->execute())
        {
            $_SESSION['name']=$customerName;
            $_SESSION['mail']=$customerEmail;
            $_SESSION['role']=$role;
            
                 echo ' <script>
                                            Swal.fire({
                                                title: "Registration successfully completed",
                                                text: "You will receive an email shortly with a verification link from the following email address.",
                                                icon: "success",
                                                showConfirmButton: false,
                                                timer: 5000 // 5 seconds
                                            }).then(function() {
                                                window.location.href = "user_verfication.php"; // Redirect after 5 seconds
                                            });
                                        </script>';
            } else {
                echo '<script>
                        Swal.fire({
                         text: "Registration failed",
                         icon: "error",
                         confirmButtonText: "OK"
                         }).then((result) => {
                              if (result.isConfirmed) {
                                   window.location.href = "register.php";
                              }
                        });
                      </script>';
            }
    }
    }
    ?>
    
    <?php
    
    if(isset($_POST['business']))
    {
        $businessName=trim($_POST['businessName']);
        $businessAddress=trim($_POST['businessAddress']);
        $industryCategory=$_POST['industryCategory'];
        $contactName=trim($_POST['contactName']);
        $businessEmail=mysqli_real_escape_string($con,$_POST['businessEmail']);
        $contactNumber=$_POST['contactNumber'];
        $npass=trim($_POST['npass']);
        $rpass=trim($_POST['rpass']);
        $city=trim($_POST['city']);
        $role="Business user";
        $status="inactive";
        

            $profilePicture = null;
              if (!empty($_FILES['profilePicture']['name'])) {
                  $target_dir = "assets/images/profile_img/";
                  $profilePicture = $target_dir . basename($_FILES['profilePicture']['name']);
                  if (!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $profilePicture)) {
                      die("Error uploading the image.");
                  }
              }

        if(! empty($_POST['regno']))
        {
            $regno=$_POST['regno'];
        }
        else
        {
            $regno=NULL;
        }
        
            $image_path = null;
          if (!empty($_FILES['businessLogo']['name'])) {
              $target_dir = "assets/images/business_logo/";
              $image_path = $target_dir . basename($_FILES['businessLogo']['name']);
              if (!move_uploaded_file($_FILES['businessLogo']['tmp_name'], $image_path)) {
                  die("Error uploading the image.");
              }
          }
          
            $check_mail = $con->prepare("SELECT * FROM user WHERE mail=?");
            $check_mail->bind_param('s', $businessEmail);
            $check_mail->execute();
            $result = $check_mail->get_result();
            
            if ($result->num_rows > 0) {
            echo '<script>
                Swal.fire({
                 text: "This email is already registered",
                 icon: "info",
                 confirmButtonText: "OK"
                 }).then((result) => {
                      if (result.isConfirmed) {
                           window.location.href = "register.php";
                      }
                });
              </script>';
            }
            else
            {
                if($npass === $rpass)
                {
                    $hashpass = password_hash($npass, PASSWORD_DEFAULT);
                    
                    $sql = $con->prepare("INSERT INTO user(name, mail, password, role, created_date, updated_date, status) VALUES(?, ?, ?, ?, ?, ?, ?)");
                    $sql->bind_param('sssssss', $contactName, $businessEmail, $hashpass, $role, $current_time, $current_time, $status);

                    if ($sql->execute()) {
                        
                        $insert_business_info=$con->prepare("INSERT INTO business_info(email,Business_name,reg_no,city,address,phone,Profile_picture,Industry_category,Business_logo,created_at,updated_at) VALUES(?, ?, ?, ?, ?, ?, ?,?,?,?,?)");
                        $insert_business_info->bind_param('sssssssssss',$businessEmail, $businessName, $regno, $city, $businessAddress, $contactNumber, $profilePicture, $industryCategory, $image_path,$current_time,$current_time);
                        if($insert_business_info->execute())
                            {
                                
                                     $_SESSION['name']=$contactName;
                                     $_SESSION['mail']=$businessEmail;
                                     $_SESSION['role']=$role;
                                     
                                    echo ' <script>
                                            Swal.fire({
                                                title: "Registration successfully completed",
                                                text: "You will receive an email shortly with a verification link from the following email address.",
                                                icon: "success",
                                                showConfirmButton: false,
                                                timer: 5000 // 5 seconds
                                            }).then(function() {
                                                window.location.href = "user_verfication.php"; // Redirect after 5 seconds
                                            });
                                        </script>';
                    } else {
                        echo '<script>
                                Swal.fire({
                                 text: "Registration failed",
                                 icon: "error",
                                 confirmButtonText: "OK"
                                 }).then((result) => {
                                      if (result.isConfirmed) {
                                           window.location.href = "register.php";
                                      }
                                });
                              </script>';
                    }
                            }
                }
                else
                {
                    echo '<script>
                    Swal.fire({
                     text: "Password not matched",
                     icon: "error",
                     confirmButtonText: "OK"
                     }).then((result) => {
                          if (result.isConfirmed) {
                               window.location.href = "register.php";
                          }
                    });
                  </script>';
                }
            }
    }
    ?>
    
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <img src="./assets/images/Logo_1.png" alt="Company Logo" id="company-logo"></a>
                        <h3>Register Your Account</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">
                                    Startup
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="business-tab" data-bs-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">
                                    Enterprise
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="registrationTabsContent">
                            <!-- Customer Tab -->
                            <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                                <form id="customerForm" method="POST">
                                    
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                            <label for="customerName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Please enter your full name" required>
                                            </div>

                                            <div class="col-6">                                                
                                        <label for="customerEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Please enter a valid email address" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                            <label for="customerPhone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="customerPhone" name="customerPhone" placeholder="Please enter a valid phone no (10 digits)" pattern="^\+?\d{10,15}$" required>
                                            </div>

                                            <div class="col-6">
                                            <label  class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" placeholder="Please enter your city" required>
                                            </div>
                                        </div>                                     
                                    </div>                                    

                                    <div class="mb-3">
                                        
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea rows="4" class="form-control" name="address" placeholder="Please enter your address" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required minlength="8" maxlength="20">
                                            </div>

                                            <div class="col-6">
                                            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Re-enter your password" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="password-strength">
                                    <div class="strength-meter">
                                        <div id="strength-bar" class="strength-bar"></div>
                                    </div>
                                    </div>
                                <br>

                                <p id="confirm-password-message">Passwords do not match!</p>

                                <button type="submit" name="customer" id="submit-btn" disabled class="btn btn-primary w-100 submit-btn">Register</button>
                                <div class="form-footer">Already have an account? <a href="login.php">Login</a></div>
                                </form>

                                <script>
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const submitButton = document.getElementById('submit-btn');
    const strengthBar = document.getElementById('strength-bar');
    const confirmPasswordMessage = document.getElementById('confirm-password-message');

    password.addEventListener('input', updatePasswordStrength);
    confirmPassword.addEventListener('input', validateConfirmPassword);

    function updatePasswordStrength() {
        const passwordValue = password.value;
        let strength = 0;

        // Check for password strength
        const criteria = [
            /[A-Z]/, // At least one uppercase letter
            /[a-z]/, // At least one lowercase letter
            /\d/,    // At least one number
            /[!@#$%^&*(),.?":{}|<>]/, // At least one special character
            /.{8,}/  // At least 8 characters
        ];

        // Check how many criteria the password meets
        criteria.forEach((regex) => {
            if (regex.test(passwordValue)) {
                strength += 1;
            }
        });

        // Set strength bar width and color based on score
        let strengthPercent = (strength / criteria.length) * 100;
        strengthBar.style.width = `${strengthPercent}%`;

        if (strengthPercent === 0) {
            strengthBar.style.backgroundColor = '#ff4d4d'; // Red (Weak)
        } else if (strengthPercent <= 40) {
            strengthBar.style.backgroundColor = '#ffcc00'; // Yellow (Moderate)
        } else if (strengthPercent <= 70) {
            strengthBar.style.backgroundColor = '#ff9900'; // Orange (Good)
        } else {
            strengthBar.style.backgroundColor = '#28a745'; // Green (Strong)
        }

        // Enable/disable submit button based on confirm password and strength
        submitButton.disabled = !isPasswordValid(passwordValue);
    }

    function isPasswordValid(passwordValue) {
        return passwordValue.length >= 8 &&
               /[A-Z]/.test(passwordValue) &&
               /[a-z]/.test(passwordValue) &&
               /\d/.test(passwordValue) &&
               /[!@#$%^&*(),.?":{}|<>]/.test(passwordValue);
    }

    function validateConfirmPassword() {
        if (password.value !== confirmPassword.value) {
            confirmPasswordMessage.style.display = 'block';
            submitButton.disabled = true;
        } else {
            confirmPasswordMessage.style.display = 'none';
            submitButton.disabled = !isPasswordValid(password.value);
        }
    }
</script>
  
                            </div>

                            <!-- Business Tab -->
                            <div class="tab-pane fade" id="business" role="tabpanel" aria-labelledby="business-tab">
                                <form id="businessForm" method="POST" enctype="multipart/form-data">
                                    <!-- Business Information -->
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                 <label for="businessName" class="form-label">Business Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="businessName" name="businessName" placeholder="Please enter a business name" required>
                                                </div>
                                                
                                                <div class="col-6">
                                                    <label for="industryCategory" class="form-label">Industry Category <span class="text-danger">*</span></label>
                                                <select class="form-select" id="industryCategory" name="industryCategory" required>
                                                    <option value="" disabled selected>Please select an industry category</option>
                                                    <option value="IT">IT</option>
                                                    <option value="Retail">Retail</option>
                                                    <option value="Healthcare">Healthcare</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Education">Education</option>
                                                </select>
                                                </div>
                                                
                                                </div>
                                        </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Registration No</label>
                                                <input type="text" class="form-control" id="businessName" name="regno" placeholder="Please enter registration no">
                                            </div>
                                            
                                            <div class="col-6">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" id="businessName" name="city" placeholder="Please enter your city">
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                     <div class="mb-3">
                                        <label for="businessAddress" class="form-label">Business Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="businessAddress" name="businessAddress" rows="3" placeholder="Please provide a business address" required></textarea>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="mb-3">
                                        <label for="contactName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Please enter full your name" required>
                                       
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                 <label for="businessEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                 <input type="email" class="form-control" id="businessEmail" name="businessEmail" placeholder="Please enter a valid email address" required>
                                            </div>
                                            
                                            <div class="col-6">
                                                <label for="contactNumber" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Please enter a valid phone no (10 digits)" pattern="^\+?\d{10,15}$" required>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="mb-3">
                                        
                                    </div>
                                  
                                  <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                                <input
                                                      type="password"
                                                      name="npass"
                                                      class="form-control"
                                                      id="userNewPassword"
                                                      placeholder="Enter new password"
                                                      required
                                                      minlength="8" maxlength="20"
                                                    />
                                            </div>

                                            <div class="col-6">
                                            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                                            <input
                                              type="password"
                                              name="rpass"
                                              class="form-control"
                                              id="userConfirmPassword"
                                              placeholder="Confirm new password"
                                              required
                                              minlength="8" maxlength="20"
                                            />
                                            </div>
                                        </div>
                                    </div>

                                    <!--<small class="password-strength-info">-->
                                    <!--    Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.-->
                                    <!--  </small>-->
                                      <div class="strength-indicator-bar"></div>
                                      <span id="userNewPasswordError" class="error-message"></span>
                                <br>

                                    <!-- Profile Setup -->
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="profilePicture" class="form-label">Profile Picture (Optional)</label>
                                        <input type="file" class="form-control" id="profilePicture" name="profilePicture" accept="image/*">
                                        <div class="form-text">Upload your profile picture (JPG, PNG, JPEG). Max size: 5MB.</div>
                                                </div>
          
                                            <div class="col-6">
                                                <label for="businessLogo" class="form-label">Business Logo <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="businessLogo" name="businessLogo" accept="image/*" required>
                                        <div class="form-text">Upload your business logo (JPG, PNG, JPEG). Max size: 5MB.</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <span id="userConfirmPasswordError" class="error-message"></span>


                                    <button type="submit" class="btn btn-primary w-100 submit-password-btn" name="business">Register</button>
                                    <div class="form-footer">Already have an account? <a href="login.php">Login</a></div>
                                </form>
                                
                                 <script>
    const newPasswordInput = document.getElementById("userNewPassword");
    const confirmPasswordInput = document.getElementById("userConfirmPassword");
    const newPasswordError = document.getElementById("userNewPasswordError");
    const confirmPasswordError = document.getElementById("userConfirmPasswordError");
    const strengthIndicatorBar = document.querySelector(".strength-indicator-bar");

    // Password Strength Checker
    newPasswordInput.addEventListener("input", () => {
      const password = newPasswordInput.value;
      const strength = getPasswordStrength(password);

      if (strength === "weak") {
        strengthIndicatorBar.className = "strength-indicator-bar weak";
      } else if (strength === "medium") {
        strengthIndicatorBar.className = "strength-indicator-bar medium";
      } else if (strength === "strong") {
        strengthIndicatorBar.className = "strength-indicator-bar strong";
      }
    });

    // Validate Passwords on Submit
    document.getElementById("businessForm").addEventListener("submit", (e) => {
      let isValid = true;

      // Validate New Password
      const newPassword = newPasswordInput.value;
      if (!isValidPassword(newPassword)) {
        newPasswordError.textContent =
          "Password must be 8-20 characters, include uppercase, lowercase, numbers, and symbols.";
        isValid = false;
      } else {
        newPasswordError.textContent = "";
      }

      // Validate Confirm Password
      const confirmPassword = confirmPasswordInput.value;
      if (newPassword !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match.";
        isValid = false;
      } else {
        confirmPasswordError.textContent = "";
      }
    });

    // Toggle Password Visibility
    function togglePasswordVisibility(fieldId) {
      const inputField = document.getElementById(fieldId);
      inputField.type =
        inputField.type === "password" ? "text" : "password";
    }

    // Check Password Strength
    function getPasswordStrength(password) {
      const hasUppercase = /[A-Z]/.test(password);
      const hasLowercase = /[a-z]/.test(password);
      const hasNumbers = /[0-9]/.test(password);
      const hasSymbols = /[!@#$%^&*(),.?":{}|<>]/.test(password);

      if (
        password.length >= 8 &&
        hasUppercase &&
        hasLowercase &&
        hasNumbers &&
        hasSymbols
      ) {
        return "strong";
      } else if (password.length >= 6) {
        return "medium";
      } else {
        return "weak";
      }
    }

    // Validate Password Format
    function isValidPassword(password) {
      const regex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,20}$/;
      return regex.test(password);
    }
  </script>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Form Validation Script -->
    <script>
        // Enable client-side form validation
        (function () {
            'use strict';

            // Get all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();

        // Validate file uploads (for Profile Picture and Logo)
        document.getElementById('businessForm').addEventListener('submit', function (e) {
            let profilePicture = document.getElementById('profilePicture').files[0];
            let businessLogo = document.getElementById('businessLogo').files[0];
            let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            let maxFileSize = 5 * 1024 * 1024; // 5MB

            // Profile Picture Validation
            if (profilePicture && !validImageTypes.includes(profilePicture.type)) {
                alert('Please upload a valid image file for the profile picture (JPG, PNG, JPEG).');
                e.preventDefault();
            } else if (profilePicture && profilePicture.size > maxFileSize) {
                alert('Profile picture size should be less than 5MB.');
                e.preventDefault();
            }

            // Business Logo Validation
            if (businessLogo && !validImageTypes.includes(businessLogo.type)) {
                alert('Please upload a valid image file for the business logo (JPG, PNG, JPEG).');
                e.preventDefault();
            } else if (businessLogo && businessLogo.size > maxFileSize) {
                alert('Business logo size should be less than 5MB.');
                e.preventDefault();
            }
        });
    </script>
    
    
    
    
</body>

</html>
