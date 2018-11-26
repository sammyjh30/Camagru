<?php
	if(!isset($_SESSION)) {session_start();}

	require('config/database.php');

	$errors = array(); 

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		//Retrieve the field values from our registration form.
		$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
		$name = !empty($_POST['name']) ? trim($_POST['name']) : null;
		$surname = !empty($_POST['surname']) ? trim($_POST['surname']) : null;
		$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
		$password_1 = !empty($_POST['password_1']) ? trim($_POST['password_1']) : null;
		$password_2 = !empty($_POST['password_2']) ? trim($_POST['password_2']) : null;

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($name)) { array_push($errors, "Name is required"); }
		if (empty($surname)) { array_push($errors, "Surname is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (empty($password_2)) { array_push($errors, "Password confirmation is required"); }
		if ($password_1 != $password_2) { array_push($errors, "Your two passwords do not match"); }
		
		if (count($errors) == 0) {
			$_SESSION['username'] = $username;
			try
			{
				$stmt = $pdo->prepare("SELECT username, email FROM users WHERE username=:username OR email=:email");
				$stmt->execute(array(':username'=>$username, ':email'=>$email));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
			
				if ($row['username']==$username) { array_push($errors, "sorry username already taken !"); }
				else if ($row['email']==$email) { array_push($errors, "sorry email id already taken !"); }
				else { echo "Username and email OK!<br/>"; }
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
			$hash = hash("whirlpool", $password_1);
			$activation_code = md5(rand());

			$sql = "INSERT INTO users (username, name, surname, email, password, activation_code) VALUES ('$username', '$name', '$surname', '$email', '$hash', '$activation_code')";
			$pdo->exec($sql);

			$base_url = "http://localhost:8080/Camagru//";
			$lastInsertId = $pdo->lastInsertId();
			if($lastInsertId) {
				$msg = "You have signed up Successfully";

				$header = "From: noreply@localhost.co.za\r\n";
				$header .= "Reply-To: noreply@localhost.co.za\r\n";
				$header .= "Return-Path: noreply@localhost.co.za\r\n";
				$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message = "<h1>Activate Your Account</h1><br/>
							<p>Hello $username,</p>
							<p>Thank you for registering to Camagru! Your username and password will work only after your email verification.</p>
							<p>Please click on the button below to verify your email address:</p><br/>
							<p><a href='" . $base_url . "confirm_email.php?username=$username&activation_code=$activation_code'>
							<button>Verify</button>
							</a></p>
							<p>Best Regards,<br />Camagru</p>";
				if (mail($email, "Activation email", $message, $header) == false)
					$_SESSION['error'] = "Error when sending email<br/>";
				$_SESSION['message'] = "Check your email for the Activation Link.";
				unset($_SESSION['username']);
			}
			else {
				$error="Something went wrong.Please try again";
				$_SESSION['error'] = $error;
			}
			unset($_SESSION['window']);
			header('Location: index.php');
		}
	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		
		//Retrieve the field values from our login form.
		$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
		$password = !empty($_POST['password']) ? trim($_POST['password']) : null;
		
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if (count($errors) == 0) {
			$password = hash("whirlpool", $password);		
			
			//Retrieve the user account information for the given username.
			$stmt = $pdo->prepare("SELECT * FROM camagru_db.users WHERE username = :usr AND password = :pass");

			//Execute.
			$stmt->execute(["usr"=>$username, "pass"=>$password]);

			//Fetch row.
			$user = $stmt->fetchAll();

			if (sizeof($user) == 1) {
				//checking if verified
				$stmt = $pdo->prepare("SELECT * FROM camagru_db.users WHERE username = :usr AND activated = 'Y'");
				$stmt->execute(["usr"=>$username]);
				$user = $stmt->fetchALL();
				if (sizeof($user) == 1) {
					$_SESSION['username'] = $username;
					$_SESSION['success'] = "You are logged in!";
				}
				else
					$_SESSION['error'] = "Please check your email to verify your account!";
			}
			else {
				$_SESSION['error'] = "Failed to get user!";
			}
			unset($_SESSION['window']);
			header('location: index.php');
		}
	}

	// Forgot Password
	if (isset($_POST['forgot_password'])) {
		$email = $_POST['email'];
		$stmt = $pdo->prepare("SELECT * FROM camagru_db.users WHERE email = '".$email."'");
		$stmt->execute();
		$results = $stmt->fetch();
		$username = $results['username'];
		$token = $results['activation_code'];
		$ver_link = 'http://localhost:8080/Camagru//index.php?password_reset="1"&token= "'.$token.'"';

		$email = $_POST['email'];
		$header = "From: noreply@localhost.co.za\r\n";
		
		$header .= "Reply-To: noreply@localhost.co.za\r\n";
		$header .= "Return-Path: noreply@localhost.co.za\r\n";
		$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = "<h1>Password Reset</h1><br/>
					<p>Hello $username,</p>
					<p>It seems you are trying to change your password.</p>
					<p>Please click on the button below to go to reset your password:</p><br/>
					<p><a href='" . $ver_link . "'>
					<button>Camagru</button>
					</a></p>
					<p>Best Regards,<br />Camagru</p>";
		if (mail($email, "Password Reset", $message, $header) == false)
			$_SESSION['error'] = "Error when sending email<br/>";
		else
			$_SESSION['message'] = "Check your email for the Password Reset.";
		unset($_SESSION['window']);
		header('location: index.php');
	}

	if (isset($_POST['password_reset'])) {
		
		if(isset($_SESSION['token'])) {
			$token = $_SESSION['token'];
			$token = str_replace('"', "", $token);
		}
		else
			{array_push($errors, "Invalid token");}
		$password_1 = !empty($_POST['password_1']) ? trim($_POST['password_1']) : null;
		$password_2 = !empty($_POST['password_2']) ? trim($_POST['password_2']) : null;
		if (empty($password_1)){array_push($errors, "Password is required");}
		if (empty($password_2)){array_push($errors, "Password Confirmation is required");}
		if ($password_1 != $password_2){array_push($errors, "Passwords do not match");}
		if(count($errors) == 0){
			try {
				$hash = hash("whirlpool", $password_1);
				$sql = "UPDATE camagru_db.users SET password='".$hash."' WHERE activation_code='".$token."'";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
			
		}
		else {
			$_SESSION['error'] = $errors[0];
			header("Refresh:0");
		}
		unset($_SESSION['token']);
		unset($_SESSION['window']);
		$_SESSION['message'] = "Password Reset Successful";
	}
	
	//receiving picture
	if(isset($_POST['submit_pic'])){
		$pic = $_POST['pic'];
		$username = $_POST['username'];
		$title = $_POST['title'];
		$description = $_POST['descrip'];
		$sql = "INSERT INTO camagru_db.pictures (username, pic, title, description) VALUES ('$username','$pic','$title','$description')";
		$pdo->exec($sql);
	}

	//Change settings
	if (isset($_POST['change_settings'])) {
		//Retrieve the field values from our registration form.
		$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
		$name = !empty($_POST['name']) ? trim($_POST['name']) : null;
		$surname = !empty($_POST['surname']) ? trim($_POST['surname']) : null;
		$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
		$password_1 = !empty($_POST['password_1']) ? trim($_POST['password_1']) : null;
		$password_2 = !empty($_POST['password_2']) ? trim($_POST['password_2']) : null;
		// $notify = 
		$value = !empty($_POST['notify']) ? trim($_POST['notify']) : null;
		// $value = $_POST['notify'];
		// echo $value;   

		if (empty($password_2) && !empty($password_1)) { array_push($errors, "Password confirmation is required"); }
		if ($password_1 != $password_2) { array_push($errors, "Your two passwords do not match"); }
		if (!empty($email)) { 
			$sql = "SELECT email FROM camagru_db.users WHERE email='".$email."'";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchALL();
			if (sizeof($results) >= 1) {
				array_push($errors, "Email address already exists");
			}
		}

		if (count($errors) == 0) {
			try
			{
				$old_name = $_SESSION['username'];
				
				if (!empty($name)) {
					$sql = "UPDATE camagru_db.users SET name='".$name."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				if (!empty($surname)) {
					$sql = "UPDATE camagru_db.users SET surname='".$surname."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				if (!empty($email)) {
					$sql = "UPDATE camagru_db.users SET email='".$email."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				if (!empty($password_1)) {
					$hash = hash("whirlpool", $password_1);
					$sql = "UPDATE camagru_db.users SET password='".$hash."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				if ($value === "on") {
					$sql = "UPDATE camagru_db.users SET notify='Y' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				else {
					$sql = "UPDATE camagru_db.users SET notify='N' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
				}
				if (!empty($username)) {
					$old_name = $_SESSION['username'];
					$sql = "UPDATE camagru_db.users SET username='".$username."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$sql = "UPDATE camagru_db.pictures SET username='".$username."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$sql = "UPDATE camagru_db.comments SET username='".$username."' WHERE username='".$old_name."'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$_SESSION['username'] = $username;
				}

			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			unset($_SESSION['window']);
			header('Location: index.php');
		}
		else {
			$_SESSION['error'] = $errors[0];
		}
		unset($_SESSION['window']);
		header("Location: index.php");
	}
?>