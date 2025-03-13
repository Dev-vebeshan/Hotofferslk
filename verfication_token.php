<?php
require_once 'db/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Account | HotOffers.lk</title>
    <link rel="icon" href="assets/images/16x16 logo.png">
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
      margin-bottom: 3px;
    }
    h1 {
      margin-bottom: 10px;
      color: #444;
      font-size: 24px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input {
     
      width: 94%; /* Adjust as needed */
  margin: 0 auto;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    input.invalid {
      border-color: red;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-top: -15px;
      margin-bottom: 15px;
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
    .forgot-password {
      text-align: right;
      margin-top: -15px;
      margin-bottom: 20px;
    }
    .forgot-password a {
      color: #f97225;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }
    .forgot-password a:hover {
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
    <?php
    
    if (isset($_GET['role']) && isset($_GET['id']) && isset($_GET['token'])) {
    $role =$_GET['role'];
    $token =$_GET['token'];     
    $token_id = $_GET['id']; 
    $status = "active";        
    $current_time = date('Y-m-d H:i:s');  
    
    if(isset($_POST['submit']))
    {
        $submit_token=$_POST['token_no'];
        
        if($submit_token==$token)
        {
                 if ($role == "Business user") {
                     
                     
            $find_status=$con->prepare("SELECT status FROM user WHERE id=?");
            $find_status->bind_param('s',$token_id);
            $find_status->execute();
            $find_result=$find_status->get_result();
            
            if($find_result->num_rows > 0)
            {
                $find_row=$find_result->fetch_assoc();
                $user_status=$find_row['status'];
                
                if($user_status != "active")
                {
                     $update_query = $con->prepare("UPDATE user SET status=?, updated_date=? WHERE id=?");
                    $update_query->bind_param('sss', $status, $current_time, $token_id);
            
                    if ($update_query->execute()) {
                           echo '<script>
                            Swal.fire({
                             text: "Your Account Successfully Activated",
                             icon: "success",
                             confirmButtonText: "OK"
                             }).then((result) => {
                                  if (result.isConfirmed) {
                                       window.location.href = "login.php";
                                  }
                            });
                          </script>';
                        exit();
                    } else {
                        echo '<script> window.location.href = "https://hotoffers.lk/register.php"; </script>';
                        exit();
                    }
                }
                else
                {
                    echo '<script>
                        Swal.fire({
                         text: "Your Account Already Activated",
                         icon: "info",
                         confirmButtonText: "OK"
                         }).then((result) => {
                              if (result.isConfirmed) {
                                   window.location.href = "login.php";
                              }
                        });
                      </script>';
                }
                
            }
            else
            {
                 echo '<script>
                        Swal.fire({
                         text: "Sorry, We cant find your account",
                         icon: "info",
                         confirmButtonText: "OK"
                         }).then((result) => {
                              if (result.isConfirmed) {
                                   window.location.href = "login.php";
                              }
                        });
                      </script>';
            }
                     
            } 
            else
            {
                
            $find_status=$con->prepare("SELECT status FROM customer WHERE id=?");
            $find_status->bind_param('s',$token_id);
            $find_status->execute();
            $find_result=$find_status->get_result();
            
            if($find_result->num_rows > 0)
            {
                $find_row=$find_result->fetch_assoc();
                $user_status=$find_row['status'];
                
                if($user_status != "active")
                {
                        $update_query = $con->prepare("UPDATE customer SET status=?, modified=? WHERE id=?");
                        $update_query->bind_param('sss', $status, $current_time, $token_id);
                
                        if ($update_query->execute()) {
                            echo '<script>
                            Swal.fire({
                             text: "Your Account Successfully Activated",
                             icon: "success",
                             confirmButtonText: "OK"
                             }).then((result) => {
                                  if (result.isConfirmed) {
                                       window.location.href = "login.php";
                                  }
                            });
                          </script>';
                            exit();
                        } else {
                            echo '<script> window.location.href = "https://hotoffers.lk/register.php"; </script>';
                            exit();
                        }
                }
                else
                {
                    echo '<script>
                        Swal.fire({
                         text: "Your Account Already Activated",
                         icon: "info",
                         confirmButtonText: "OK"
                         }).then((result) => {
                              if (result.isConfirmed) {
                                   window.location.href = "login.php";
                              }
                        });
                      </script>';
                }
                
            }
            else
            {
                 echo '<script>
                        Swal.fire({
                         text: "Sorry, We cant find your account",
                         icon: "info",
                         confirmButtonText: "OK"
                         }).then((result) => {
                              if (result.isConfirmed) {
                                   window.location.href = "login.php";
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
                 text: "Invalid Token No",
                 icon: "error",
                 confirmButtonText: "OK"
                 }).then((result) => {
                      if (result.isConfirmed) {
                           window.location.href = "verfication_token.php";
                      }
                });
              </script>';
        }
    }
}
else
{
    echo '<script> window.location.href = "https://hotoffers.lk/login.php"; </script>';
    exit();
}
    
    ?>
    

  <div class="form-container">
    <div class="form-header">
      <a href="index.php">
    <img src="https://hotoffers.lk//assets/images/Logo_1.png" alt="Company Logo">
</a>

      <h1>Verification Token</h1>
    </div>
    <form id="login-form" method="POST">

      <input type="text" id="token" name="token_no" placeholder="Enter your token" required>

      <button type="submit" name="submit">
           <span id="loginText" id="loginButton">Submit</span>
          <span id="spinner" class="loading-spinner ml-2"></span> <!-- Initially hidden spinner -->
    </button>
    </form>

  </div>

<script>
     // JavaScript to handle button loading
    document.getElementById('login-form').addEventListener('submit', function (e) {
      
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
