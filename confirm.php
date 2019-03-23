<?php
	function redirect() {
		header('Location: register.php');
		exit();
	}

	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		redirect();
	} else {
        $con = mysqli_connect('localhost', 'id8770852_sandman', 'qwerty123', 'id8770852_userdb');

		$email = $con->real_escape_string($_GET['email']);
		$token = $con->real_escape_string($_GET['token']);

        $sql = "SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailConfirmed=0";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE users SET isEmailConfirmed=1, token='' WHERE email='$email'";
            $result = mysqli_query($con, $sql);

        } else {
            redirect();
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
        <h2 class="display-3">Email verification complete !!</h2>
        <p class="lead"> Please <a href="login.php">Login</a> to continue </p>
    </div>
</body>
</html>