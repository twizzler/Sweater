<html>
  <head>
    <title>Sweater - Register</title>
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="sweetalert-master/dist/sweetalert.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script src="sweetalert-master/dist/sweetalert.min.js"></script>
	
<?php

class Registration extends PDO {

	private $config = [
		'Host' => 'localhost',
		'Database' => 'sweater',
		'User' => 'root',
		'Pass' => '',
	];

	public function __construct(){
		parent::__construct('mysql:host='. $this->config['Host'] . ';dbname=' . $this->config['Database'], $this->config['User'], $this->config['Pass']);
	}

	public function encryptPassword($password, $md5 = true) {
		if($md5 !== false) {
			$password = md5($password);
		}

		$hash = substr($password, 16, 16) . substr($password, 0, 16);
		return $hash;
	}

	public function sendError($errorType, $message){
		switch($errorType){
			case "success":
				$error = "<div class=\"alert alert-success\">{$message}</div>";
			break;
			case "error":
				$error = "<div class=\"alert alert-danger\">{$message}</div>";
			break;
		}

		return $error;
	}

	public function getLoginHash($password, $staticKey) {
		$hash = $this->encryptPassword($password, false);
		$hash .= $staticKey;
		$hash .= 'Y(02.>\'H}t":E1';
		$hash = $this->encryptPassword($hash);
		$hash = password_hash($hash, PASSWORD_DEFAULT, [ 'cost' => 12 ]);

		return $hash;
	}

	public function addUser($username, $email, $password, $color){
		$hashedPassword = strtoupper(md5($password));
		$staticKey = 'e4a2dbcca10a7246817a83cd';
		$fancyPassword = $this->getLoginHash($hashedPassword, $staticKey);

		$strQuery = "INSERT INTO users (Username, Password, Email, RegisteredTime, Color) VALUES (:username, :password, :email, :registered_time, :color)";
		$insertUser = $this->prepare($strQuery);
		$insertUser->bindValue(":username", $username);
		$insertUser->bindValue(":email", $email);
		$insertUser->bindValue(":registered_time", time());
		$insertUser->bindValue(":password", $fancyPassword);
		$insertUser->bindValue(":color", $color);
		$insertUser->execute();

		$insertUser->closeCursor();
	}

	public function usernameExists($username){
		$strQuery = 'SELECT Username FROM users WHERE Username = :username';
		$checkUsername = $this->prepare($strQuery);
		$checkUsername->bindValue(':username', $username);
		$checkUsername->execute();
		$usernameExists = $checkUsername->rowCount() > 0;
		return $usernameExists;
	}

	public function EmailExists($email){
		$strQuery = 'SELECT Email FROM users WHERE Email = :email';
		$checkEmail = $this->prepare($strQuery);
		$checkEmail->bindValue(':email', $email);
		$checkEmail->execute();
		$emailExists = $checkEmail->rowCount() > 0;
		return $emailExists;
	}

}


$db = new Registration();

if(isset($_POST) && !empty($_POST)){
	if(isset($_POST["username"],$_POST["email"], $_POST["password"], $_POST["repassword"], $_POST["penguinColor"], $_POST["g-recaptcha-response"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["repassword"]) && !empty($_POST["penguinColor"]) && !empty($_POST["g-recaptcha-response"])){

			$strUsername = $_POST["username"];
			$strEmail = $_POST["email"];
			$strPassword = $_POST["password"];
			$strRePassword = $_POST["repassword"];
			$intColor = $_POST["penguinColor"];
			$strCaptcha = $_POST["g-recaptcha-response"];
			$intIP = $_SERVER['REMOTE_ADDR'];
			$strSecretKey = '6Lei8BMTAAAAAGpIzsW_zCgqnWA4qEgBm0HArkUf';
			$strResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$strSecretKey."&response=".$strCaptcha."&remoteip=".$intIP);
			$strResponseKeys = json_decode($strResponse, true);

			$strBadNames = array('fuck','nigger','cunt','twat','shit','bitch','whore','hoe','ass','bum','cock','dick',
			'clit','pussy','dickhead','nigga','pervert','retard','aids','wanker','gay','niggerfaggot','niggerfaggot69');

			if($db->usernameExists($strUsername)){
				$error = $db->sendError('error', 'Username already in use');
			}

			elseif(in_array($strUsername, $strBadNames)){
				$error = $db->sendError('error', 'This is username is not allowed');
			}

			elseif($db->emailExists($strEmail)){
				$error = $db->sendError('error', 'Email already in use');
			}

			elseif(strlen($strUsername) == 0){
				$error = sendError('error', 'You need to provide a name for your penguin.');
			}
			elseif(strlen($strUsername) < 4 || strlen($strUsername) > 21){
				$error = $db->sendError('error', 'Your penguin name is either too short or too long.');
			}
			elseif(preg_match_all("/[0-9]/", $strUsername) > 21){
				$error = $db->sendError('error', 'Your penguin name can only contain 21 numbers.');
			}
			elseif(!preg_match("/[A-z]/i", $strUsername)){
				$error = $db->sendError('error', 'Penguin names must contain at least 1 letter.');
			}
			elseif(preg_match('/[^a-z0-9\s]/i', $strUsername)){
				$error = $db->sendError('error', 'That username is not allowed.');
			}
			elseif(!filter_var($strEmail, FILTER_VALIDATE_EMAIL)){
				$error = $db->sendError('error', 'Your email isn\'t valid.');
			}
			elseif(strlen($strPassword) < 4) {
				$error = $db->sendError('error', "Your password is too short!");
			}
			elseif($strPassword != $strRePassword){
				$error = $db->sendError('error', "Passwords do not match!");
			}
			elseif(!$strCaptcha){
				$error = $db->sendError('error', 'Please fill out the captcha.');
				die();
			}
			elseif(intval($strResponseKeys["success"]) !== 1) {
				$error = $db->sendError('error', 'Hello Spammer!');
			}

			if(empty($error)){
				$db->addUser($strUsername, $strEmail, $strPassword, $intColor);

				echo '<script language="javascript">';
				echo 'window.onload = function () {';
				echo 'swal("Well done!", "You have successfully registered!", "success")';
				echo '};';
				echo '</script>';

			}
	} else
		{
			$error = $db->sendError('error', "Please complete all the fields.");
		}
}

?>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/" style="padding-top:13.5px;"><img style="height:85px;margin-top: -13px;" src=""></img></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
     </ul>
     <ul class="nav navbar-nav navbar-right">
       <li><a href="#">Home</a></li>
      </ul>
   </div><!-- /.navbar-collapse -->
      </div>
    </nav>
    <div class="container">

	<div>
	<center>
	 <br /><img src="./assets/images/create_account.png" style="margin-left: -392px;width: 1920px;margin-top: -71px;">
	 <h3>Create an Account</h3>
	 <br />
	 <br />
	</center>
	</div>
	
<div>

<center>
<div class="register-form">
<form method="POST" action="">
	<?php
	if(isset($error))
	{
		echo $error;
	}
	?>
	<div class="form-group">
	  <input type="text" name="username" class="form-control" placeholder="Penguin Name" min="4" maxlength="21" />
	</div>
	<div class="form-group">
		<input type="email" name="email" class="form-control" placeholder="Email" id="inputDefault" maxlength="40" />

	</div>
	<div class="form-group">
		<input type="password" name="password" class="form-control" placeholder="Password" id="inputDefault" maxlength="1000" />
	</div>
	<div class="form-group">
		<input type="password" name="repassword" class="form-control" placeholder="Repeat Password" id="inputDefault" maxlength="1000" />
	</div>
  <div class="form-group">
      </div>
      <div style="margin-left: -160px;" class="g-recaptcha" data-sitekey="6Lei8BMTAAAAAHJPbumNV5wjZJsY_8axnQvigdVt"></div><br>
  <input type="submit" class="btn btn-success" value="Sign Up" style="margin-left: -342px;width: 111px;margin-top: -16px;"></input>
  <input type="hidden" value="1" id="penguinColorInput" name="penguinColor" />
</form>

	<div class="foo blue" id="c1" style="opacity: 1;" onclick="changeImage('./colors/1.png')"></div>
	<div class="foo green" id="c2" style="opacity: 0.5;" onclick="changeImage('./colors/2.png')"></div>
	<div class="foo pink" id="c3" style="opacity: 0.5;" onclick="changeImage('./colors/3.png')"></div>
	<div class="foo black" id="c4" style="opacity: 0.5;" onclick="changeImage('./colors/4.png')"></div>
	<div class="foo red" id="c5" style="opacity: 0.5;" onclick="changeImage('./colors/5.png')"></div>
	<div class="foo orange" id="c6" style="opacity: 0.5;" onclick="changeImage('./colors/6.png')"></div>
	<div class="foo yellow" id="c7" style="opacity: 0.5;" onclick="changeImage('./colors/7.png')"></div>
	<br>
	<div class="foo purple" id="c8" style="opacity: 0.5;" onclick="changeImage('./colors/8.png')"></div>
	<div class="foo brown" id="c9" style="opacity: 0.5;" onclick="changeImage('./colors/9.png')"></div>
	<div class="foo lightpink" id="c10" style="opacity: 0.5;" onclick="changeImage('./colors/10.png')"></div>
	<div class="foo darkgreen" id="c11" style="opacity: 0.5;" onclick="changeImage('./colors/11.png')"></div>
	<div class="foo lightblue" id="c12" style="opacity: 0.5;" onclick="changeImage('./colors/12.png')"></div>
	<div class="foo lightgreen" id="c13" style="opacity: 0.5;" onclick="changeImage('./colors/13.png')"></div>
	<div class="foo grey" id="c14" style="opacity: 0.5;" onclick="changeImage('./colors/14.png')"></div>

	<img id="imgDisp" alt="" src="colors/1.png" style="margin-left:603px;margin-top: -397px;"/>

</div>

<script>

function changeImage(imgName)
{
    image = document.getElementById('imgDisp');
    image.src = imgName;
    var colorId = imgName.replace("./colors/", "");
    colorId = colorId.replace(".png", "");
    document.getElementById("penguinColorInput").value = colorId;

    for (i = 1; i < 15; i++) {
        document.getElementById("c" + i).style.opacity = 0.5;
    }
    document.getElementById("c" + colorId).style.opacity = 1;
}

</script>

</center>

    </div>
    <br /><br /><br /><br />
    <center><small>Club Penguin Artwork is owned by The Walt Disney Company and Club Penguin and is used under Fair Use for Education.</small></center>
  </body>
</html>
</center>
</div>
</div>
</body>
</html>
