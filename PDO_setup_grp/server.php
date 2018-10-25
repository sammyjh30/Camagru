<?php
session_start();

require('connect.php');

$errors = array(); 

$stmt = $pdo->prepare("SELECT * FROM camagru_db.users WHERE username = :usr OR email = :eml");
$stmt->execute(["usr"=>$username, "eml"=>$email]);
$results = $stmt->fetchAll();

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

		// $hash = password_hash($password_1, PASSWORD_DEFAULT);
		$hash = password_hash($password_1, PASSWORD_BCRYPT, array("cost" => 12));
		// $hashed_password = "$2y$10$BBCpJxgPa8K.iw9ZporxzuW2Lt478RPUV/JFvKRHKzJhIwGhd1tpa";
		$activation_code = md5(rand());

		// Query for Insertion
		$sql="INSERT INTO users(username, name, surname, email, password, activation_code) VALUES(:username,:name,:surname,:email,:password)";
		$query = $pdo->prepare($sql);
		// Binding Post Values
		$query->bindParam(':username',$username,PDO::PARAM_STR);
		$query->bindParam(':name',$name,PDO::PARAM_STR);
		$query->bindParam(':surname',$surname,PDO::PARAM_STR);
		$query->bindParam(':email',$email,PDO::PARAM_INT);
		$query->bindParam(':password',$hash,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $pdo->lastInsertId();
		if($lastInsertId) {
			$msg="You have signup  Scuccessfully";

			// if(isset($result))
			// {
				// https://www.webslesson.info/2017/12/php-registration-script-with-email-confirmation.html
			 $base_url = "http://localhost/Camagru_repository/PDO_setup_grp/";
			 $mail_body = "
			 <p>Hello ".$_POST['username'].",</p>
			 <p>Thank you for registering to Camagru! Your username and password will work only after your email verification.</p>
			 <p>Please Open this link to verified your email address - ".$base_url."email_verification.php?activation_code=".$user_activation_code."
			 <p>Best Regards,<br />Webslesson</p>
			 ";
			 require 'class/class.phpmailer.php';
			 $mail = new PHPMailer;
			 $mail->IsSMTP();        //Sets Mailer to send message using SMTP
			 $mail->Host = 'smtpout.secureserver.net';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
			 $mail->Port = '80';        //Sets the default SMTP server port
			 $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
			 $mail->Username = 'xxxxxxxx';     //Sets SMTP username
			 $mail->Password = 'xxxxxxxx';     //Sets SMTP password
			 $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
			 $mail->From = 'info@webslesson.info';   //Sets the From email address for the message
			 $mail->FromName = 'Webslesson';     //Sets the From name of the message
			 $mail->AddAddress($_POST['user_email'], $_POST['user_name']);  //Adds a "To" address   
			 $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
			 $mail->IsHTML(true);       //Sets message type to HTML    
			 $mail->Subject = 'Email Verification';   //Sets the Subject of the message
			 $mail->Body = $mail_body;       //An HTML or plain text message body
			 if($mail->Send())        //Send an Email. Return true on success or false on error
			 {
			  $message = '<label class="text-success">Register Done, Please check your mail.</label>';
			 }

		}
		else {
			$error="Something went wrong.Please try again";
		}
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
		//Retrieve the user account information for the given username.
		$sql = "SELECT id, username, password FROM users WHERE username = :username";
		$stmt = $pdo->prepare($sql);

		//Bind value.
		$stmt->bindValue(':username', $username);

		//Execute.
		$stmt->execute();

		//Fetch row.
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		//If $row is FALSE.
		if($user === false){
			//Could not find a user with that username!
			//PS: You might want to handle this error in a more user-friendly manner!
			echo 'Username failed<br/>';
			die('Username failed<br/>Incorrect username / password combination!');
		}
		else {
			//User account found. Check to see if the given password matches the
			//password hash that we stored in our users table.
			
			//Compare the passwords.
			$validPassword = password_verify($password, $user['password']);

			//If $validPassword is TRUE, the login has been successful.
			if($validPassword){
				
				//Provide the user with a login session.
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['logged_in'] = time();
				$_SESSION['username'] = $user['username'];
				
				//Redirect to our protected page, which we called home.php
				header('Location: index.php');
				exit;
				
			}
			else {
				//$validPassword was FALSE. Passwords do not match.
				die('Password failed<br/>Incorrect username / password combination!');
			}
		}
	}
}
  
?>