<?php
session_start();
require_once 'db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $type=$_POST['type'];
    $status="active";

    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }
    else
    {
        if($type=="customer")
        {
            $sql=$con->prepare("SELECT * FROM customer WHERE email =? AND status=?");
            $sql->bind_param('ss',$email,$status);
            $sql->execute();
            $result=$sql->get_result();

            if($result->num_rows > 0)
            {
                    $row=$result->fetch_assoc();
                    $user_id=$row['id'];
                    $fetch_password=$row['password'];

                    if(password_verify($password,$fetch_password))
                    {
                        $check_session=$con->prepare("SELECT * FROM session WHERE user_id=? AND mail=?");
                        $check_session->bind_param('is', $user_id,$email); 
                        $check_session->execute();
                        $session_result = $check_session->get_result();

                        if($session_result->num_rows > 0)
                        {
                            $session_row=$session_result->fetch_assoc();
                            $auth_user_id=$session_row["user_id"];
                            $auth_user_mail=$session_row["mail"];
                            $auth_user_role=$session_row["role"];
                            $auth_user_access_key=$session_row["access_key"];
                
                            $_SESSION['access_key'] = $auth_user_access_key;
                            $_SESSION['customer_mail'] = $auth_user_mail;
                            $_SESSION['customer_id']= $auth_user_id;
                            $_SESSION['customer_name'] =htmlspecialchars($row['name']);
                            $_SESSION['customer_role'] = $auth_user_role;
                
                            echo "<script>location.replace('./dashboard/home.php');</script>";
                        }
                        else
                        {
                            $encryptkey=$email."+".$user_id;
                            $access_key=md5($encryptkey);
                            $user_type="customer";
                
                            $insert=$con->prepare("INSERT INTO session (user_id,mail,role,access_key,created_at) VALUES (?,?,?,?,now())");
                            $insert->bind_param('isss', $user_id,$email,$user_type,$access_key);

                            if($insert->execute())
                          {
                            $_SESSION['access_key'] = $access_key;
                            $_SESSION['customer_mail'] = $email;
                            $_SESSION['customer_id']= $user_id;
                            $_SESSION['customer_name'] =htmlspecialchars($row['name']);
                            $_SESSION['customer_role'] = $user_type;
            
                            echo "<script>location.replace('./dashboard/home.php');</script>";
                          }
                          else
                          {
                            echo "<script>location.replace('login.php');</script>";
                          }
                        }

                    }
                    else
                    {
                        echo "Incorrect Password";
                    }
            }
            else
            {
                echo "Incorrect Login Attempt";
            }
        }
        else
        {
            $role="Business user";
            $sql=$con->prepare("SELECT * FROM user WHERE mail =? AND status=? AND role=?");
            $sql->bind_param('sss',$email,$status,$role);
            $sql->execute();
            $result=$sql->get_result();

            if($result->num_rows > 0)
            {
                    $row=$result->fetch_assoc();
                    $user_id=$row['id'];
                    $fetch_password=$row['password'];
            
                    if(password_verify($password,$fetch_password))
                    {
                        $check_session=$con->prepare("SELECT * FROM session WHERE user_id=? AND mail=?");
                        $check_session->bind_param('is', $user_id,$email); 
                        $check_session->execute();
                        $session_result = $check_session->get_result();

                        if($session_result->num_rows > 0)
                        {
                            $session_row=$session_result->fetch_assoc();
                            $auth_user_id=$session_row["user_id"];
                            $auth_user_mail=$session_row["mail"];
                            $auth_user_access_key=$session_row["access_key"];

                            $_SESSION['access_key'] = $auth_user_access_key;
                            $_SESSION['admin_mail'] = $auth_user_mail;
                            $_SESSION['admin_name'] = htmlspecialchars($row['name']);
                            $_SESSION['admin_role'] = $role;

                            echo "<script>location.replace('./admin/index.php');</script>";
                        }
                        else
                        {
                            $encryptkey=$email."+".$user_id;
                            $access_key=md5($encryptkey);

                            $insert=$con->prepare("INSERT INTO session (user_id,mail,role,access_key,created_at) VALUES (?,?,?,?,now())");
                            $insert->bind_param('isss', $user_id,$email,$role,$access_key);

                            if($insert->execute())
                            {
                                $_SESSION['access_key'] = $access_key;
                                $_SESSION['admin_mail'] = $email;
                                $_SESSION['admin_name'] = htmlspecialchars($row['name']);
                                $_SESSION['admin_role'] = $role;

                                echo "<script>location.replace('./admin/index.php');</script>";
                            }
                            else
                            {
                                echo "<script>location.replace('login.php');</script>";
                            }
                        }

                    }
                    else
                    {
                        echo "Incorrect Password";
                    }
            }
            else
            {
                echo "Incorrect Login Attempt";
            }

        }
        }
    }              
?>
