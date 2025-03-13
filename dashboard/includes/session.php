<?php

include '../db/connection.php';
session_start();

$current_time = date("Y-m-d H:i:s"); // Current timestamp

if (isset($_SESSION['customer_name']) && isset($_SESSION['customer_id']) && isset($_SESSION['access_key']) && isset($_SESSION['customer_mail']) && isset($_SESSION['customer_role'])) {
    $customer_id = $_SESSION['customer_id'];
    $customer_name = $_SESSION['customer_name'];
    $customer_mail = $_SESSION['customer_mail'];
    $customer_role=$_SESSION['customer_role'];

    $sql=$con->prepare("SELECT * FROM customer WHERE email=?");
    $sql->bind_param('s',$customer_mail);
    $sql->execute();
    $result=$sql->get_result();
    
    if($result->num_rows > 0)
    {
        $row=$result->fetch_assoc();
        $customer_phone=$row['phone'];
        $customer_address=$row['address'];
        $customer_city=$row['city'];

                if($row['picture'] !="")
            {
                $customer_profile=$row['picture'];
            }
            else
            {
                $customer_profile="../dashboard/assets/img/user.png";
            
            }

            if($row['status']==="active")
            {
                $status='<span class="inline-flex items-center rounded-xl shadow-md bg-green-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-green-500">Active</span>';
            }
            else
            {
                $status='<span class="inline-flex items-center rounded-xl shadow-md bg-red-600 px-2 py-2 text-xs font-medium text-white ring-1 ring-inset ring-red-600">Inactive</span>';
            }

    

    }
    else 
    {
        echo "<script> location.replace('../login.php');</script>";
    }

    

    
} 
else 
{
    echo "<script> location.replace('../login.php');</script>";
}

?>