<?php

session_start();
$_SESSION['message'] = '';

$db_name = 'accounts';
$db_host = 'localhost';
$db_user = 'root';

$mysqli = new mysqli($db_host, $db_user, '', $db_name);


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if($_POST['password'] == $_POST['confirmpassword']){

        print_r($_FILES); die;

        $username = $mysqli ->real_escape_string($_POST['username']);
        $email = $mysqli ->real_escape_string($_POST['email']);
        $password = md5($_POST['password']);
        $avatar_path = $mysqli ->real_escape_string('image/'.$_FILES['avatar']['name']);


            if(preg_match("!image!", $_FILES['avatar']['type'])){

                if (copy($_FILES['avatar']['tmp_name'], $avatar_path))
                {
                    //set session variables to display on welcome page
                    $_SESSION['username'] = $username;
                    $_SESSION['avatar'] = $avatar_path;
                
                    //create SQL query string for inserting data into the database
                    $sql = "INSERT INTO users (username, email, password, avatar) "
                    . "VALUES ('$username', '$email', '$password', '$avatar_path')";
                }
                
                //check if mysql query is successful
if ($mysqli->query($sql) === true)
{
    $_SESSION[ 'message' ] = "Registration succesful! Added $username to the database!";
    //redirect the user to welcome.php
    header( "location: welcome.php" );
}




            }
    }
}

?>
                                

<link href= "//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Create an account</h1>
    <form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
      <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
      <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>