<?php
    error_reporting(0);
    $msg = "";
    $msg1="";
	use PHPMailer\PHPMailer\PHPMailer;

	if (isset($_POST['submit'])) {
        $con = mysqli_connect('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');

		$name = $con->real_escape_string($_POST['name']);
		$email = $con->real_escape_string($_POST['email']);
		$password1 = $con->real_escape_string($_POST['password']);
		$password2 = $con->real_escape_string($_POST['cPassword']);

		if ($name == "" || $email == "" || $password1 != $password2)
			$msg = "Please check your inputs!";
		else {
            $con = mysqli_connect('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');
            $sql = "SELECT id FROM users WHERE email='$email'";
            $result = mysqli_query($con, $sql);

			if (mysqli_num_rows($result) > 0) {
				$msg = "<div class='alert alert-dismissible alert-warning'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                Email already exists in database.
              </div>";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password1, PASSWORD_BCRYPT);
                $con = mysqli_connect('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');
				$sql = "INSERT INTO users (firstName,email,password,isEmailConfirmed,token,passwordToken)
                VALUES ('$name', '$email', '$hashedPassword', '0', '$token','')";
                if (mysqli_query($con, $sql)) {
                    $msg = "Registration complete. Please check your email.";
                }
                
                include_once "PHPMailer/PHPMailer.php";

                $mail = new PHPMailer();
                $mail->setFrom('admin@phplogsys.com','Aditya');
                $mail->addAddress($email, $name);
                $mail->Subject = "Please verify email!";
                $mail->isHTML(true);
                $mail->Body = "Hello $name, <br>
                    Please click on the link below to confirm your email.<br><br>
                    
                    <a href='http://phplogsys.000webhostapp.com/confirm.php?email=$email&token=$token'>Confirm email</a>
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
        $con->close();
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">

                <h1 class="display-3"> Register </h1> <br>
                <?php if ($msg != "") 
                echo $msg; ?>
                <br>
				<form method="post" action="register.php">
					<input class="form-control" name="name" placeholder="Name..."><br>
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" name="password" type="password" placeholder="Password..."><br>
					<input class="form-control" name="cPassword" type="password" placeholder="Confirm Password..."><br>
					<input class="btn btn-primary" type="submit" name="submit" value="Register">
				</form> <br>
                <p class="lead">Already a user? <a href="login.php" class="btn btn-default">Log in</a>.</p>
			</div>
		</div>
	</div>
</body>
</html>