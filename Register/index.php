<?php

$pageTitle = 'Sweater - Register';

include('./includes/config.php');

if(isset($_POST) && !empty($_POST)){
  if(isset($_POST["username"], $_POST["password"], $_POST["confirm_password"], $_POST["color"]) && !empty($_POST["username"] && !empty($_POST["password"]) && !empty($_POST["confirm_password"]) && !empty($_POST["color"]))){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $repassword = $_POST["confirm_password"];
    $color = $_POST["color"];

	$checkUser =  $database->prepare("SELECT Username from users WHERE Username = :username");
	$checkUser->bindValue(':username', $username);
	$checkUser->execute();
	$userTaken = $checkUser->rowCount();
	if($userTaken > 0){
		$error = 'Woops username exists';
	}elseif(!ctype_alnum($username)){
       		$error = "Username can only contain numbers and letters."; 
    	}elseif($password != $repassword){
        	$error = "Passwords do not match !";
    	}else{
	$insertUser = $database->prepare("INSERT INTO users (Username, Password, Color) VALUES (:username, :password, :color)");
        $insertUser->bindValue(":username", $username);
        $insertUser->bindValue(":password", md5($password));
        $insertUser->bindValue(":color", $color);
        $insertUser->execute();

        $userID = $database->lastInsertId();

        $_SESSION["userId"] = $userID;

        echo '<div class="alert alert-success">You have successfully registered</div>';
    }

  }else{
    $error = "Please complete all the fields.";
  }
}

?>
<?php

include ('./includes/header.php');

 ?>
  <center>
 <br /><h3>Register</h3>
 <style>
 input{
   width: 300px;
 }
 .alert{
   width: 300px;
 }
 </style>
 <br />
 <?php

 if(isset($error)){
   echo '<div class="alert alert-danger">'.$error.'</div>';
 }

  ?>
  <br />
<form method="POST" action="">
  <input type="text" name="username" placeholder="Username"></input><br /><br />
  <input type="password" name="password" placeholder="Password"></input><br /><br />
  <input type="password" name="confirm_password" placeholder="Confirm your password"></input><br /><br />
  <select name="color" style="width: 300px; height: 30px;">
	<option class="selected">Select a color</option>
	<option value="1">Blue</option>
	<option value="2">Green</option>
	<option value="3">Pink</option>
	<option value="4">Black</option>
	<option value="5">Yellow</option>
	<option value="6">Dark Purple</option>
	<option value="7">Brown</option>
	<option value="8">Peach</option>
	<option value="9">Red</option>
	<option value="10">Orange</option>
	<option value="11">Dark Green</option>
	<option value="12">Light Blue</option>
	<option value="13">Lime Green</option>
	<option value="14">Aqua</option>
	<option value="15">Grey</option>
	<option value="16">Arctic White</option>
  </select><br><br>
  <input class="btn btn-primary btn-lg" type="submit" value="Sign Up"></input>
</form>
<center>
<?php

include ('./includes/footer.php');

?>
