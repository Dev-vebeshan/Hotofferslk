<?php
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

		//$mail->SMTPDebug =0;

		$mail->isSMTP();

		$mail->Host = 'smtp.gmail.com';

		$mail->SMTPAuth = true;

		$mail->Username ='activedigitallabs@gmail.com';

		$mail->Password ='unvu iwnq wayc fypt';

		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

		$mail->Port = 587;

		$mail->setFrom('activedigitallabs@gmail.com','Hotofferslk');

		$mail->addAddress($email);

		$mail->isHTML(true);

		$mail->Subject ='New Message';

		$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://hotoffers.lk/assets/images/logo_white.png" alt="Logo">
        </div>
        <div class="email-body">
            <h1>'.$subject.'</h1>
            <p>Hi Admin,<br>
            New message from '.$email.' <br> Message : '.$message.'</p>
            <br>
        </div>
    </div>
</body>
</html>';
		$html .= '</div> </body></html>';

        $mail->Body    =$html;

		$mail->send();

	}
    catch(Exception $e)
     {
		echo "Mail Could not be Sent. Mailer Error: {$mail->ErrorInfo}";
	 }
    exit();
?>