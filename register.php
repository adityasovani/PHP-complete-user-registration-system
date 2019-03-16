<?php
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
				$msg = "Email already exists in the database!";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password1, PASSWORD_BCRYPT);
                $con = mysqli_connect('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');
				$sql = "INSERT INTO users (firstName,email,password,isEmailConfirmed,token)
                VALUES ('$name', '$email', '$hashedPassword', '0', '$token')";
                if (mysqli_query($con, $sql)) {
                    $msg = "Registration complete. Please check your email.";
                }
                
                include_once "PHPMailer/PHPMailer.php";

                $mail = new PHPMailer();
                $mail->setFrom('admin@phplogsys.com');
                $mail->addAddress($email, $name);
                $mail->Subject = "Please verify email!";
                $mail->isHTML(true);
                $mail->Body = "Hello $name, <br>
                    Please click on the link below:<br><br>
                    
                    <a href='http://phplogsys.000webhostapp.com/confirm.php?email=$email&token=$token'>Click Here</a>
                ";

                if ($mail->send())
                    $msg = "You have been registered! Please verify your email!";
                else
                    $msg = "Something wrong happened! Please try again!";
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">

                <h1 class="display-3"> Register </h1> <br>
				<?php if ($msg != "") echo $msg."<br><br>" ?>
                <?php if ($msg != "") echo $msg1."<br><br>" ?>
                <br>
				<form method="post" action="register.php">
					<input class="form-control" name="name" placeholder="Name..."><br>
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" name="password" type="password" placeholder="Password..."><br>
					<input class="form-control" name="cPassword" type="password" placeholder="Confirm Password..."><br>
					<input class="btn btn-primary" type="submit" name="submit" value="Register">
				</form>

			</div>
		</div>
	</div>
</body>
</html>