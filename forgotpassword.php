<?php
    if(isset($_POST['submit'])){
        $conn = new mysqli('localhost','id8770852_sandman','qwerty123','id8770852_userdb');
        
        $email = $con->real_escape_string($_POST['email']);
        
        $sql = $con->query("SELECT email from users WHERE email='$email'");
        if($sql->num_rows == 0) {
            echo "Email doesnt exist";
        } else {
            $passwordToken = hash('Sha512','dhumbar78barde.xembarab./a.out_o9oom88/avtya344_tyav');
            $passwordToken = str_shuffle($passwordToken);
            $passwordToken = substr($passwordToken,12,37);

            //Update passwordToken
            $con->query("UPDATE users SET passwordToken='$passwordToken'WHERE email='$email'");
            $con->close();

            //Send RESET link via mail
            include_once "PHPMailer/PHPMailer.php";

            $mail = new PHPMailer();
            $mail->setFrom('admin@phplogsys.com','Aditya');
            $mail->addAddress($email, $name);
            $mail->Subject = "Please verify email!";
            $mail->isHTML(true);
            $mail->Body = "Hello $name, <br>
                Please click on the link below to reset your password.<br><br>
                
                <a href='http://phplogsys.000webhostapp.com/confirm.php?email=$email&passwordToken=$passwordToken'>Reset password</a>
            ";

            if ($mail->send())
                $msg = "<div class='alert alert-dismissible alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Registration complete !</strong> Please check your email for confirmation.
              </div>";
            else
                $msg = "<div class='alert alert-dismissible alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Something wrong happened</strong> Please try again.
              </div>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
    <div class="jumbotron text-center">
        <h2 class="display-3">Reset Your Password !!</h2>
        <form action="forgotpassword.php.php" method="post">
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter registered email" /> <br>
            <input type="submit" class="btn btn-primary" value="Send reset link"/>
        </form>
    </div>
</body>
</html>