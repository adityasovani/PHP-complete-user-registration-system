<?php
    if(!isset($_GET['keyToken'])){
        header('location: login.php');
    } else {
       
            $con = mysqli_connect('localhost', '<your database username>', '<your database password>', 'id8770852_userdb');
    
            $email = $con->real_escape_string($_GET['email']);
            $keyToken = $con->real_escape_string($_GET['keyToken']);
            $msg = $_GET['mp'];
            if ($msg == 'false') {
                $msg = "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                Passwords do not match.</div>";            }
    
            $sql = "SELECT id FROM users WHERE email='$email' AND keyToken='$keyToken'";
            $result = mysqli_query($con, $sql);
    
            if (mysqli_num_rows($result) == 0) {
                header('location: login.php');
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Set New password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center" style="padding-top:4%;">
        <h3 class="display-4"> Reset password </h3>
        <form action="setPass.php" method="post">
            <p> Reset password for <?php echo $email; ?> </P><br>
            <input type="password" value="" class="form-control" placeholder="New password" name="password" id="password" required/> <br>
            <input type="password" value="" class="form-control" placeholder="Re-enter new password" name="password2" id="password2" required/> <br>
            <input type="hidden" name="email" value='<?php echo $email; ?>' />
            <input type="submit" name="submit" class="btn btn-primary" />
        </form>
    </div>
</body>
</html>