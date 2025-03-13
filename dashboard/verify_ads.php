<?php
include './includes/session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../includes/Exception.php';
require '../includes/PHPMailer.php';
require '../includes/SMTP.php';

require '../mailer/autoload.php';

if (isset($_SESSION['ad_data'])) {

    $adData = $_SESSION['ad_data'];
    
    $title = $adData['title'];
    $description = $adData['description'];
    $price = $adData['price'];
    $sale_price = $adData['sale_price'];
    $discount = $adData['discount'];
    $category = $adData['category'];
    $type = $adData['type'];
    $start_date = $adData['start_date'];
    $end_date = $adData['end_date'];
    $location = $adData['location'];
    $status = $adData['status'];
    $author_name = $adData['author_name'];
    $author_mail = $adData['author_mail'];
    $image_path =str_replace('../', './', $adData['image_path']);
}
else
{
    echo "<script> location.replace('my-ads.php'); </script>";
}

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

		$mail->addAddress('activedigitallabs@gmail.com');

		$mail->isHTML(true);

		$mail->Subject ='Verify Advertisement';

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
            font-size: 20px;
            margin-bottom: 20px;
        }
        .email-body p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        caption {
            font-size: 1.5em;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        
        <div class="email-body">
            <center><img src="https://hotoffers.lk/'.$image_path.'" style="width:400px; height:400px;"></center>
            <h1>'.$title.'</h1>
            <p>'.$description.'</p>
             <table width="100%" border="1">
        <tr>
            <td>Price</td> <td>Rs '.$price.'</td>
        </tr>
        <tr>
            <td>Sale Price</td> <td>Rs '.$sale_price.'</td>
        </tr>
        <tr>
            <td>Discount</td> <td>'.$discount.'%</td>
        </tr>
        <tr>
            <td>Category</td> <td>'.$category.'</td>
        </tr>
        <tr>
            <td>Type</td> <td>'.$type.'</td>
        </tr>
        <tr>
            <td>Location</td> <td>'.$location.'</td>
        </tr>
        <tr>
            <td>Start Date</td> <td>'.$start_date.'</td>
        </tr>
        <tr>
            <td>End Date</td> <td>'.$end_date.'</td>
        </tr>
        <tr>
            <td>Author</td> <td>'.$author_name.' '.$author_mail.'</td>
        </tr>
    </table>
            <a href="https://hotoffers.lk/admin/verify-ads.php" style="display: inline-block;
            background-color: #f97225;
            color: white;
            text-decoration: none;
            font-weight:bold;
            padding: 15px 25px;
            font-size: 16px;
            border-radius: 5px;">Verify</a>
            <br>
            <p style="text-align:center; font-size:14px;">Once verified, this advertisement will publish your website</p>
        </div>
    </div>
</body>
</html>';
		$html .= '</div> </body></html>';

        $mail->Body    =$html;

		$mail->send();
		
		echo "<script> location.replace('my-ads.php'); </script>";
	}
    catch(Exception $e)
     {
		echo "Mail Could not be Sent. Mailer Error: {$mail->ErrorInfo}";
	 }
    exit();
    
    
    	
?>