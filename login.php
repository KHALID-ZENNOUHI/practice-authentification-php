<?php 
require 'config.php';
session_start();
if(isset($_POST['submi'])){
    extract($_POST);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $password_hash = MD5($password);
    
    $select = "SELECT * FROM user_form where email =  '$email' and password = '$password_hash';";
    $resutl = mysqli_query($conn,$select);
    if(mysqli_num_rows($resutl)> 0){
        $row = mysqli_fetch_array($resutl);
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row ['name'];
            header('location:admin.php');
        }elseif($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row ['name'];
            header('location:user.php');
        }
    }else{
        $error[] = 'incorrect email or password!';
    }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method = "post">
            <h3>login now</h3>
            <?php if(isset($error)){
                foreach ($error as $error) {
                    echo '<span class = "error_msg">'.$error.'</span>';
                }
            } ?>
            <input type="email" name ="email" required placeholder = "enter your Email">
            <input type="password" name ="password" required placeholder = "enter your password">
            <input type="submit" name = "submi" value = "login now" class="form-btn">
            <p>don't have an account? <a href="register.php">register now now</a></p>
        </form>
    </div>
</body>
</html>