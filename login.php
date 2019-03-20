<?php
	session_start();
	$msg = "";
	$errMsg = "";
	if(isset($_GET['resetStatus'])){
		$resetStatus = $_GET['resetStatus'];
		if ($resetStatus == 'success') {
			$msg = "<div class='alert alert-dismissible alert-success'>
			<button type='button' class='close' data-dismiss='alert'>&times;</button>
			Password reset successful</div>";
		}
	}
	if (isset($_SESSION['errMsg'])) {		
		$errMsg = $_SESSION['errMsg'];
		$errMsg1 = "<div class='alert alert-dismissible alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		'$errMsg' </div>";
	}
	if (isset($_POST['submit'])) {
		$con = new mysqli('localhost', '<your database username>', '<your database password>', 'id8770852_userdb');

		$email = $con->real_escape_string($_POST['email']);
		$password = $con->real_escape_string($_POST['password']);

		if ($email == "" || $password == "")
			$msg = "<div class='alert alert-dismissible alert-warning'>
			<button type='button' class='close' data-dismiss='alert'>&times;</button>
			Please fill all the fields </div>";
		else {
			$sql = $con->query("SELECT id, password, isEmailConfirmed FROM users WHERE email='$email'");
			if ($sql->num_rows > 0) {
                $data = $sql->fetch_array();
                if (password_verify($password, $data['password'])) {
                    if ($data['isEmailConfirmed'] == 0)
	                    $msg = "Please verify your email!";
                    else {
						$_SESSION['email'] = $email;
						$_SESSION['loggedIn'] = 1;
						$session = substr(str_shuffle('869e85a6636faaead32aecc050f2008e9fe39cd1116633dcfaba33'),10,48);
						$con->query("UPDATE users SET token='$session'WHERE email='$email'");
						header('location: https://phplogsys.000webhostapp.com/dashboard.php');
						exit();
                    }
                } else
	                $msg = "<div class='alert alert-dismissible alert-danger'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					Invalid credentials </div>";
			} else {
				$msg = "<div class='alert alert-dismissible alert-danger'>
				<button type='button' class='close' data-dismiss='alert'>&times;</button>
				Invalid credentials </div>";
			}
		}
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Log In</title>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px;">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
            <h1 class="display-3"> Login </h1> <br>
				<?php 
				if ($msg != "") echo $msg."<br>";
				if($errMsg != "") echo $errMsg1;
				?>

				<form method="post" action="login.php">
					<input class="form-control" name="email" type="email" placeholder="Email..."><br>
					<input class="form-control" name="password" type="password" placeholder="Password..."><br>
					<input class="btn btn-primary" type="submit" name="submit" value="Log In">
				</form> <br>
				<p class="lead">New user? <a href="register.php" >Register</a> | <a href="forgotpassword.php"> Forgot password ?</a></p>
			</div>
		</div>
	</div>
</body>
</html>