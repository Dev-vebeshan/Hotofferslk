<?php

require_once 'db/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name =trim($_POST['name']);
    $email =mysqli_real_escape_string($con,$_POST['email']);
    $subject =trim($_POST['subject']);
    $message =$_POST['message'];

    $status=1;


    $select=mysqli_query($con,"SELECT * FROM user WHERE role='admin' AND status='active' ");
    if(mysqli_num_rows($select) > 0)
    {
        $row=mysqli_fetch_array($select);
        $admin_mail=$row['mail'];

        $insert=$con->prepare("INSERT INTO inbox(name,sender,receiver,title,message,created_at,status) VALUES(?,?,?,?,?,?, ?)");
        $insert->bind_param('ssssssi',$name,$email,$admin_mail,$subject,$message,$current_time,$status);

        if($insert->execute())
        {
            
            echo json_encode(['success' => true, 'message' => 'Your Message successfully submitted']);
            include('sent_message_mail.php');
        }
        else
        {
            echo json_encode(['success' => false, 'message' => 'Your Message not submitted']);
        }
    }


    
}
?>
