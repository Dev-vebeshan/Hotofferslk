<?php
try{
session_start();
require_once 'db/connection.php';
require_once 'vendor/autoload.php';
$error = '';

$client = new Google_Client();
$client->setClientId('425995119801-bfao363m32t81nmkube6fll46sj6n849.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://hotoffers.lk/google-login-callback.php');
$client->addScope("email");
$client->addScope("profile");
}
catch(Exception $e)
     {
		echo "<script> location.replace(login.php); </script>";
	 }
?>


<?php

if(isset($_GET['usertype']))
{
    $usertype=$_GET['usertype'];
    $_SESSION['usertype']=$usertype;
    $loginUrl = $client->createAuthUrl();
    echo '<script>window.location.href = "'.$loginUrl.'";</script>';
    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login to Your Account | HotOffers.lk</title>
    <meta name="description" content="Access your HotOffers.lk account to view exclusive deals and manage your preferences. Log in now to unlock the best offers in Sri Lanka!">
    <meta name="keywords" content="login, account access, HotOffers.lk, exclusive deals">
    <meta name="author" content="HotOffers.lk">
    <link rel="icon" href="assets/images/16x16 logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #f97225, #ff8e4f); color: white; font-family: "Poppins", sans-serif; }
        .hidden { display: none; }
        .container-box { background: rgba(255, 255, 255, 0.2);  border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); width: 90%; max-width: 350px;}
        .card-container { display: flex; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
        .card { background: rgba(255, 255, 255, 0.9); border: none; border-radius: 10px; transition: transform 0.3s; width: 100%;}
        .card:hover { transform: scale(1.02); }
        .btn-custom { background: #f97225; color: white; border: none; }
        .btn-custom:hover { background: #e5601e; }
        .form-control { border-radius: 15px; }
        .icon { font-size: 1.5rem; margin-right: 8px; }
        a{
            text-decoration: none;
            color: #f97225;
        }
        a:hover
        {
            color: #ff8e4f;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div id="login-form" class="container-box text-center">
        <div class="row">
            <div class="col-12">
                <div class="card text-center" style="max-width: 350px;">
                    <center> <img src="assets/images/Logo_1.png" alt="login" style="padding: 10px; width: 150px;"></center>
                    <center><img src="assets/images/login.png" class="card-img-top" alt="login" style="max-height: 180px; max-width: 180px;"></center>
                    <div class="card-body">
                        <h5 class="text-center text-dark">Get Started Today!</h5>
                        <button class="btn btn-custom m-2 w-100" id="show-login"><i class="fa-solid fa-sign-in-alt"></i> Sign in</button>
                        <a href="register.php" class="btn btn-secondary m-2 w-100"><i class="fa-solid fa-user-plus"></i> Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="card-selection" class="hidden container mt-4 p-4 text-center" style="border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); background: rgba(255, 255, 255); max-width: 600px;">
        <button class="btn btn-custom d-flex align-items-center justify-content-center" id="back-to-login"><i class="fa-solid fa-arrow-left me-2"></i></button>
        
        <center> <img src="assets/images/Logo_1.png" alt="Startup" style="padding: 10px; width: 180px;"></center>
        <h6 class="text-center text-dark">Pick the right plan and move forward with ease! 🚀</h6>
        <div class="row justify-content-center g-4">
            
            <div class="col-md-6 d-flex justify-content-center">
                <div class="card text-center p-3" style="width: 100%; max-width: 300px;">
                    <img src="assets/images/startup.png" class="card-img-top mx-auto" alt="Startup" style="width: 100%; max-width: 250px;">
                    <div class="card-body">
                        <button class="btn btn-custom w-100 mt-2 continue" id="startup"><i class="fa-solid fa-rocket"></i> Sign in as Startup</button>
                        <a href="login.php?usertype='startup'" class="btn btn-outline-danger w-100 mt-2 text-sm"><i class="fa-brands fa-google"></i> sign in with Google</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <div class="card text-center p-3" style="width: 100%; max-width: 300px;">
                    <img src="assets/images/enterprise.png" class="card-img-top mx-auto" alt="Enterprise" style="width: 100%; max-width: 250px;">
                    <div class="card-body">
                        <button class="btn btn-custom w-100 mt-2 continue" id="enterprise"><i class="fa-solid fa-building"></i> Sign in as Enterprise</button>
                        <a href="login.php?usertype='enterprise'" class="btn btn-outline-danger w-100 mt-2 text-sm"><i class="fa-brands fa-google"></i> sign in with Google</a>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center text-dark">Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
    

    <div id="user-login" class="hidden container-box text-center">
        <div class="row">
            <div class="col-12">
                <div class="card text-center" style="max-width: 350px;">
                    <center> <img src="assets/images/Logo_1.png" alt="login" style="padding: 10px; width: 150px;"></center>
                    <center><img src="assets/images/login.png" class="card-img-top" alt="login" style="max-height: 180px; max-width: 180px;"></center>
                    <div class="card-body">
                        <form id="loginForm">
                        <h5 id="usertype" class="text-center text-dark"></h5>
                        <div id="loginMessage" class="mt-2 text-danger"></div> <!-- Error Message Box -->
                        <input type="hidden" name="type" id="type" value="">
                        <input type="email" class="form-control w-100 my-2" placeholder="Enter Gmail" name="email" id="email" required>
                        <input type="password" class="form-control w-100 my-2" placeholder="Enter Password" name="password" id="password" required min="8" max="20">
                        <a href="forgot_password.php" id="forgotPasswordLink" style="text-align:left; color:red;" class="mb-2">Forget password?</a>
                        <button class="btn btn-custom w-100" type="submit"><i class="fa-solid fa-sign-in-alt"></i> Sign in</button>
                        <button class="btn btn-outline-secondary mt-3 w-100" id="back-to-cards"><i class="fa-solid fa-arrow-left"></i> Back</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        const enterprise=document.getElementById('enterprise');
        const startup=document.getElementById('startup');
        let usertype=document.getElementById('usertype');
        const forgotPasswordLink = document.querySelector('a[href="forgot_password.php"]');

        $(document).ready(function(){
            $("#show-login").click(function(){
                $("#login-form").hide();
                $("#card-selection").fadeIn();
            });
            $(".continue").click(function(){
                $("#card-selection").hide();
                $("#user-login").fadeIn();
            });
            $("#back-to-login").click(function(){
                $("#card-selection").hide();
                $("#login-form").fadeIn();
            });
            $("#back-to-cards").click(function(){
                $("#user-login").hide();
                $("#card-selection").fadeIn();
                $("#type").val("");
                $("#loginMessage").html("");
                $("#email").html("");
                $("#email").val("");
                $("#password").html("");
                $("#password").val("");
            });

            $("#startup").click(function(){
                $("#usertype").text("Sign as Startup");
                $("#type").val('customer');
                 forgotPasswordLink.href = "forgot_password.php?user=startup";
            });

            $("#enterprise").click(function(){
                $("#usertype").text("Sign as Enterprise");
                $("#type").val('business');
                forgotPasswordLink.href = "forgot_password.php?user=enterprise";
            });
        });

        $(document).ready(function(){
    $("#loginForm").submit(function(e){
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "login-backend.php", // Backend PHP file
            type: "POST",
            data: $(this).serialize(), // Send form data
            success: function(response){
                if (response == "success") {
                    window.location.href = "dashboard.php"; // Redirect on success
                } else {
                    $("#loginMessage").html(response); // Show error message
                }
            }
        });
    });
});

    </script>
</body>
</html>
