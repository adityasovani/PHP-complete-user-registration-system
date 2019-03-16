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

            echo "Verification complete!";
        } else {
            redirect();
        }
	}
?>