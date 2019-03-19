<?php
	use PHPMailer\PHPMailer\PHPMailer;
    $msg = "";
    if(isset($_POST['submit'])){
        $con = new mysqli('localhost','id8770852_sandman','qwerty123','id8770852_userdb');
        if (!$con) {
            echo "crap";
        }
        
        $email = $con->real_escape_string($_POST['email']);
        
        $sql = $con->query("SELECT email from users WHERE email='$email'");
        if($sql->num_rows == 0) {
            $msg = "<div class='alert alert-dismissible alert-warning'>
			<button type='button' class='close' data-dismiss='alert'>&times;</button>
			Email doesn't exist.</div>";
        } else {
            $sql1 = $con->query("SELECT firstName from users WHERE email='$email'");
            $data = $sql1->fetch_array();
            $name = $data['firstName'];
            $passwordToken = hash('Sha512','dhumbar78barde.xembarab./a.out_o9oom88/avtya344_tyav');
            $passwordToken = str_shuffle($passwordToken);
            $passwordToken = substr($passwordToken,12,37);
            $auth = hash('Sha512','d8cmw9ds)knw5s2(mwn%ss5#$32!2ss');
            //Update passwordToken
            $con->query("UPDATE users SET keyToken='$passwordToken'WHERE email='$email'");
            $con->close();

            //Send RESET link via mail
            include_once "PHPMailer/PHPMailer.php";

            $mail = new PHPMailer();
            $mail->setFrom('admin@phplogsys.com','Aditya');
            $mail->addAddress($email, $name);
            $mail->Subject = "Reset Password";
            $mail->isHTML(true);
            $mail->Body = "Hello $name, <br>
                Please click on the link below to reset your password.<br><br>
                
                <a href='http://phplogsys.000webhostapp.com/newpassword.php?email=$email&keyToken=$passwordToken&auth=$auth'>Reset password</a>
            ";

            if ($mail->send())
                $msg = "<div class='alert alert-dismissible alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Email sent!</strong> Please check your email.
              </div>";
            else
                $msg = "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Aw crap!</strong> Please try again.
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center" style="padding-top:4%">
        <h2 class="display-4">Reset Your Password !!</h2> <br>
        <?php 
            if ($msg != "") {
                echo "'$msg'<br>";
            }
        ?>
        <form action="forgotpassword.php" method="post">
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter registered email" required/> <br>
            <input type="submit" name='submit' class="btn btn-primary" value="Send reset link"/>
        </form>
    </div>
</body>
</html>