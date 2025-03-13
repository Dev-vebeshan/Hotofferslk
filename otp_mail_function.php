<?php
require_once 'db/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'includes/Exception.php';
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';

require 'mailer/autoload.php';

if(isset($_SESSION['reset_mail']) && isset($_SESSION['name']) && isset($_SESSION['type']))
{
    $reset_mail=$_SESSION['reset_mail'];
    $customer_name=$_SESSION['name'];
    $type=$_SESSION['type'];

	$mail= new PHPMailer(true);

	try{

		//$mail->SMTPDebug =0;

		$mail->isSMTP();

		$mail->Host = 'smtp.gmail.com';

		$mail->SMTPAuth = true;

		$mail->Username ='activedigitallabs@gmail.com';

		$mail->Password ='unvu iwnq wayc fypt';

		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		$mail->Port = 587;

		$mail->setFrom('activedigitallabs@gmail.com','Hotofferslk');

		$mail->addAddress($reset_mail);

		$mail->isHTML(true);

		$verification_code = substr(number_format(time()*rand(),0,'',''),0,6);

		$mail->Subject ='Verification Code';

		$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://hotoffers.lk/assets/images/logo_white.png" alt="Logo">
        </div>
        <div class="email-body">
            <h1>Email Verification</h1>
            <p>Hi '.$customer_name.',<br>
            We received a request to reset your password. To proceed, please use the following One-Time Password (OTP) to verify your identity:</p>
            <a href="#">Your OTP Code: '.$verification_code.' </a>
            <br>
            <p style="text-align:center; font-size:14px;">Once verified, you’ll be able to set a new password and regain access to your account.</p>
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

		$mail->send();
		
		if($type=="startup")
		{
		    $update_otp=$con->prepare("UPDATE customer SET otp_no=?, otp_date=? WHERE email=? ");
            $update_otp->bind_param('sss',$verification_code,$current_time,$reset_mail);
    
            if($update_otp->execute())
            {
                echo "<script>location.replace('otp.php'); </script>";
            }
		    
		}
		else
		{
		    if($type=="enterprise")
		    {
		        $update_otp=$con->prepare("UPDATE user SET otp_no=?, otp_date=? WHERE mail=? ");
                $update_otp->bind_param('sss',$verification_code,$current_time,$reset_mail);
        
                if($update_otp->execute())
                {
                    echo "<script>location.replace('otp.php'); </script>";
                }
		    }
		}
	}
    catch(Exception $e)
     {
		echo "OTP Could not be Sent. Mailer Error: {$mail->ErrorInfo}";
	 }
    exit();
}
// else
// {
//     echo "<script>location.replace('forgot_password.php'); </script>";
// }
?>