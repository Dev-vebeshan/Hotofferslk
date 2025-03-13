<?php

require_once 'db/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name =trim($_POST['name']);
    $email =mysqli_real_escape_string($con,$_POST['email']);
    $rating =$_POST['rating'];
    $review =mysqli_real_escape_string($con,$_POST['review']);

    $ads_id=$_POST['ads_id'];
    $brand_id=$_POST['brand_id'];
    $cat_id=$_POST['cat_id'];

    $insert=$con->prepare("INSERT INTO review (name,email,rating,review,ads_id,brand_id,cat_id,created_at) VALUES(?,?,?,?,?,?,?,?)");
    $insert->bind_param('ssssiiis',$name,$email,$rating,$review,$ads_id,$brand_id,$cat_id,$current_time);

    if($insert->execute())
    {
        echo json_encode(['success' => true, 'message' => 'Your review successfully submitted']);
    }
    else
    {
        echo json_encode(['success' => false, 'message' => 'Your review not submitted']);
    }
}
?>
