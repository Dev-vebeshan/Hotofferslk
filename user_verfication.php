<?php
session_start();


require_once 'db/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'includes/Exception.php';
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';

require 'mailer/autoload.php';

	$mail= new PHPMailer(true);
	
	try{
	
	if(isset($_SESSION['mail']) && isset($_SESSION['name']) && isset($_SESSION['role']))
        {
            $user_mail=$_SESSION['mail'];
            $user_name=$_SESSION['name'];
            $role=$_SESSION['role'];
            $status = "active"; 
            
            if($role=="customer")
            {
                $query=$con->prepare("SELECT * FROM customer WHERE email=? And NOT status=?");
                $query->bind_param('ss',$user_mail,$status);
                $query->execute();
                $result=$query->get_result();
                
                if($result->num_rows > 0)
                {
                    $row=$result->fetch_assoc();
                    $fetch_id=$row['id'];
                }
                else
                {
                    echo "<script> alert('Invalid Mail'); </script>;";
                }
            }
            else
            {
                $query=$con->prepare("SELECT * FROM user WHERE mail=? And role=? AND NOT status=?");
                $query->bind_param('sss',$user_mail,$role,$status);
                $query->execute();
                $result=$query->get_result();
                
                if($result->num_rows > 0)
                {
                    $row=$result->fetch_assoc();
                    $fetch_id=$row['id'];
                }
                else
                {
                    echo "<script> alert('Invalid Mail'); </script>;";
                }
            }

		//$mail->SMTPDebug =0;

		$mail->isSMTP();

		$mail->Host = 'smtp.gmail.com';

		$mail->SMTPAuth = true;

		$mail->Username ='activedigitallabs@gmail.com';

		$mail->Password ='unvu iwnq wayc fypt';

		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		$mail->Port = 587;

		$mail->setFrom('activedigitallabs@gmail.com','Hotofferslk');

		$mail->addAddress($user_mail);

		$mail->isHTML(true);

		$mail->Subject ='User Verification';
		
		$token=md5($user_mail);
		
		$url = 'https://hotoffers.lk/verfication_token.php/?role=' .urlencode($role). '&id=' .urlencode($fetch_id). '&token='.urlencode($token);

		$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Email Verification</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background-color: #f97225;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .email-header img {
            display: block;
            margin: 0 auto;
            max-width: 150px;
        }
        .email-body {
            padding: 20px;
            text-align: center;
        }
        .email-body h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }
        .email-body a {
            display: inline-block;
            background-color: #f97225;
            color: white;
            text-decoration: none;
            font-weight:bold;
            padding: 15px 25px;
            font-size: 16px;
            border-radius: 5px;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #ddd;
            background-color: #f9f9f9;
            font-size: 14px;
        }
        .email-footer a {
            color: #555;
            text-decoration: none;
            margin: 0 10px;
        }
        .email-footer .social-icons img {
            width: 24px;
            margin: 0 5px;
        }
        .verify-btn {
            background-color: #f97225;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .verify-btn:hover {
            background-color: #ff5713;
        }

        .verify-btn:focus {
            outline: none;
        }

        .status-message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://hotoffers.lk/assets/images/logo_white.png" alt="Logo">
        </div>
        <div class="email-body">
            <h1>User Verification</h1>
            <p>Hi '.$user_name.',<br>
            Thank you for registering with us! To complete your registration and verify your identity, please click the button below</p>
            <br>Your Token No : <b> '.$token.'</b><br>
            <a href="'.$url.'" style="background-color: #f97225; color: white; padding: 12px 20px; font-size: 16px; font-weight: 500; border-radius: 5px; text-decoration: none; display: inline-block; text-align: center;">Verify Your Account</a>
            <p style="text-align:center; font-size:14px;">This link will expire in soon. If you did not request this verification, please ignore this message.</p>
        </div>
        <div class="email-footer">
            <p>No 12/3, Nelum Mawatha, Aththidiya, Dehiwala</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/share/15CmdVjt8o/?mibextid=wwXIfr"><img src="https://hotoffers.lk/assets/images/facebook.png" alt="Facebook"></a>
                <a href="https://www.instagram.com/hotoffers.lk/"><img src="https://hotoffers.lk/assets/images/instagram.png" alt="Instagram"></a>
            </div>
            <p><a href="https://hotoffers.lk/privacy-policy.php">Privacy Policy</a> | <a href="https://hotoffers.lk/contact.php">Contact Details</a></p>
        </div>
    </div>
</body>
</html>';
		$html .= '</div> </body></html>';

        $mail->Body    =$html;
        
        if($mail->send())
        {
            echo "<script> location.replace('login.php'); </script>";
        }
        else
        {
            echo "<script> alert('Mail Not Send...'); </script>;";
        }


	}

	}
    catch(Exception $e)
     {
		echo "OTP Could not be Sent. Mailer Error: {$mail->ErrorInfo}";
	 }
?>