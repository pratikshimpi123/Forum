<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_db_connect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signuppassword'];
    $cpass = $_POST['signupcpassword'];

    // Check whetehe this email exists or not
    $existSql = "select * from `users` where user_email = '$user_email'";
    $result = mysqli_query($conn,$existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows < 0){
        $showError = "Email is already exist";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass,PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                $showAlert = true;
                header("Location: /Forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Password do not match";
        }
    }
    header("Location: /Forum/index.php?signupsuccess=false&error=$showError");
}


?>