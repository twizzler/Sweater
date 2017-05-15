<?php

	require_once('recaptchalib.php');

	$pageTitle = 'Sweater - Register';

	include('./includes/config.php');
	

	function sendError($errorType, $message)
	{
		switch($errorType)
		{
			case "success":
				$error = "<div class=\"alert alert-success\">{$message}</div>";
			break;
			case "error":
				$error = "<div class=\"alert alert-danger\">{$message}</div>";
			break;
		}

		return $error;
	}

	if(isset($_POST) && !empty($_POST))
	{
		if(isset($_POST["username"],$_POST["email"], $_POST["password"], $_POST["repassword"], $_POST["penguinColor"], $_POST["g-recaptcha-response"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["repassword"]) && !empty($_POST["penguinColor"]) && !empty($_POST["g-recaptcha-response"]))
		{

			$strUsername = $_POST["username"];
			$strEmail = $_POST["email"];
			$strPassword = $_POST["password"];
			$strRePassword = $_POST["repassword"];
			$intNow = time();
			$intColor = $_POST["penguinColor"];
			$strCaptcha = $_POST["g-recaptcha-response"];
			$strSecretKey = "6Lei8BMTAAAAAGpIzsW_zCgqnWA4qEgBm0HArkUf";
			$intIP = $_SERVER['REMOTE_ADDR'];
			$strResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$strSecretKey."&response=".$strCaptcha."&remoteip=".$intIP);
			$strResponseKeys = json_decode($strResponse, true);

			$checkUser =  $database->prepare("SELECT Username from users WHERE Username = :username");
			$checkUser->bindValue(':username', $strUsername);
			$checkUser->execute();
			$userTaken = $checkUser->rowCount() > 0;
		
			$checkEmail =  $database->prepare("SELECT Email from users WHERE Email = :email");
			$checkEmail->bindValue(':email', $strEmail);
			$checkEmail->execute();
			$emailTaken = $checkEmail->rowCount() > 0;
		
			if($userTaken)
			{
				$error = sendError('error', 'Woops username already in use');
			} 
			elseif($emailTaken) 
			{
				$error = sendError('error', 'Woops email already in use');
			}
			elseif(strlen($strUsername) == 0)
			{
				$error = sendError('error', 'You need to name your penguin');
			}
			elseif(strlen($strUsername) < 4 || strlen($strUsername) > 12)
			{
				$error = sendError('error', 'Your penguin name is either too short or too long');
			}
			elseif(preg_match_all("/[0-9]/", $strUsername) > 5) 
			{
				$error = sendError('error', 'Your penguin name can only contain 5 numbers');
			}
			elseif(!preg_match("/[A-z]/i", $strUsername)) 
			{
				$error = sendError('error', 'Penguin names must contain at least 1 letter.');
			}
			elseif(preg_match('/[^a-z0-9\s]/i', $strUsername))
			{
				$error = sendError('error', 'That username is not allowed.');
			}
			if(!filter_var($strEmail, FILTER_VALIDATE_EMAIL))
			{
				$error = sendError('error', 'Your email isn\'t valid');
			}
			elseif($strPassword != $strRePassword) 
			{
				$error = sendError('error', "Passwords do not match !");
			}
			elseif(!$strCaptcha) 
			{
				$error = sendError('error', 'Please fill out the captcha');
				die();
			}
			elseif(intval($strResponseKeys["success"]) !== 1) {
				$error = sendError('error', 'You are spammer ! Get the @$%K out');
			}
			else
			{
				$insertUser = $database->prepare("INSERT INTO users (Username, Email, RegisteredTime, Password, Color) VALUES (:username, :email, :registered_time, :password, :color)");
				$insertUser->bindValue(":username", $strUsername);
				$insertUser->bindValue(":email", $strEmail);
				$insertUser->bindValue(":registered_time", $intNow);
				$insertUser->bindValue(":password", md5($strPassword));
				$insertUser->bindValue(":color", $intColor);
				$insertUser->execute();
				
				if($insertUser->execute()){
					echo 'You have successfully registered';
				}
				$penguinId = $database->lastInsertId();
		
			}
		}
		else 
		{
			$error = sendError('error', "Please complete all the fields.");
		}
	}

?>
<?php include ('./includes/header.php'); ?>

<div>
<center>
 <h3>Create an Account</h3>
 <br />
 <br />
</center>
</div>
 

 
<div class="register-form"> 
<form method="POST" action="">
	<?php 
	if(isset($error))
	{
		echo $error;
	}
	?>
	<div class="form-group">
	  <input type="text" name="username" class="form-control" placeholder="Username" id="inputDefault">
	</div>
	<div class="form-group">
		<input type="email" name="email" class="form-control" placeholder="Email" id="inputDefault">
	</div>
	<div class="form-group">
		<input type="password" name="password" class="form-control" placeholder="Password" id="inputDefault">
	</div>
	<div class="form-group">
		<input type="password" name="repassword" class="form-control" placeholder="Confirm Password" id="inputDefault">
	</div>
	 <select name="penguinColor" style="width: 300px; height: 30px;">
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
    <div style="margin-left:152px;">
    </div>
  <div class="form-group">
      </div>
      <div style="margin-left:150px;"><div class="g-recaptcha" data-sitekey="6Lei8BMTAAAAAHJPbumNV5wjZJsY_8axnQvigdVt"></div></div><br>
  <input type="submit" class="btn btn-success" value="Sign Up" style="width: 111px; margin-left: 151px;margin-top: -16px;"></input>
</form>
 
</div>
 
<?php
 
include ('./includes/footer.php');
 
?>
