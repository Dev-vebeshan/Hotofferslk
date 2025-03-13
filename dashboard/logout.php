<?php

include './includes/session.php';

// Check if the session variables exist before using them
if (isset($_SESSION['customer_mail']) && isset($_SESSION['customer_role'])) {
    $customer_mail = $_SESSION['customer_mail'];
    $customer_role = $_SESSION['customer_role'];

    // Prepare the DELETE statement
    $delete = $con->prepare("DELETE FROM session WHERE mail=? AND role=? ");
    $delete->bind_param('ss', $customer_mail, $customer_role);
    $delete->execute();
}

// Destroy session completely
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to login page
echo "<script> location.replace('../login.php'); </script>";
exit();
?>
