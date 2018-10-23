<?php
session_start();

// initializing variables
$servername = "localhost";
$username = "root";
$password = "Samanthajh30";
$my_db = "camagru_db";
$errors = array(); 

//connecting to Database
$pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_EMULATE_PREPARES => false);
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $pdoOptions);

//connecting to Database
$pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_EMULATE_PREPARES => false);
$pdo = new PDO("mysql:host=$servername;dbname=$my_db", $username, $password, $pdoOptions);

// REGISTER USER
if (isset($_POST['reg_user'])) {
	//Retrieve the field values from our registration form.
	$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
	$name = !empty($_POST['name']) ? trim($_POST['name']) : null;
	$surname = !empty($_POST['surname']) ? trim($_POST['surname']) : null;
	$email = !empty($_POST['email']) ? trim($_POST['email']) : null;
	$password_1 = !empty($_POST['password_1']) ? trim($_POST['password_1']) : null;
	$password_2 = !empty($_POST['password_2']) ? trim($_POST['password_2']) : null;

	//TO ADD: Error checking (username characters, password length, etc). Basically, you will need to add your own error checking BEFORE the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
	// $sql = $pdo->query("SELECT * FROM camagru_db.users WHERE username = :username OR email = :email");
	// // $sql = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	// $stmt->execute(["username"=>$username, "email"=>$email]);
	// $result = $stmt->fetchAll();
	// $stmt = $pdo->prepare($sql);
	
	$stmt = $pdo->prepare('SELECT username FROM camagru_db.users WHERE username = :username');
    $stmt->execute(array(':username' => $_POST['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($row['username'])){
        $error[] = 'Username provided is already in use.';
    }
	//TO ADD: Error checking (username characters, password length, etc). Basically, you will need to add your own error checking BEFORE the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    //Construct the SQL statement and prepare it.
	// $sql = "SELECT * FROM camagru_db.users WHERE username = :username OR email = :email";
	// // $sql = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
	// $stmt->execute(["username"=>$username, "email"=>$email]);
	// $result = $stmt->fetchAll();
	// $stmt = $pdo->prepare($sql);
	
	//Bind the provided username to our prepared statement.
	// $stmt->bindValue(':username', $username);

	//Execute.
	// $stmt->execute();
	//Fetch the row.
	// $row = $stmt->fetch(PDO::FETCH_ASSOC);
	// if($row['num'] > 0){
    //     array_push($errors, "Username already exists");
	// }
	// if ($user['email'] === $email) {
	// 	array_push($errors, "email already exists");
	// }

	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	if (sizeof($result) >= 1) {
		array_push($errors, "Username/Email already in use.");
	}

	//Hash the password as we do NOT want to store our passwords in plain text.
	$passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
    
	//Prepare our INSERT statement. Remember: We are inserting a new row into our users table.
	$sql = "INSERT INTO users (username, name, surname, email, password) VALUES ('$username', '$name', '$surname', '$email', '$password')";
	// $sql = "INSERT INTO users (username, name, surname, email, password, confirmcode) VALUES ('$username', '$name', '$surname', '$email', '$password', '$confirmcode')";
	$stmt = $pdo->prepare($sql);

	//Bind our variables.
	$stmt->bindValue(':username', $username);
	$stmt->bindValue(':password', $passwordHash);
   
	//Execute the statement and insert the new account.
	$result = $stmt->execute();
	  
	//If the signup process is successful.
	if($result){
		//What you do here is up to you!
		echo 'Thank you for registering with our website.';
	}
}

// LOGIN USER
if (isset($_POST['login_user'])) {
	
	//Retrieve the field values from our login form.
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
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
    if($user === false) {
        //Could not find a user with that username!
        //PS: You might want to handle this error in a more user-friendly manner!
        die('Incorrect username / password combination!');
	}
	else {
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.
        
        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);
        
        //If $validPassword is TRUE, the login has been successful.
        if($validPassword){
            
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
            
            //Redirect to our protected page, which we called home.php
            header('Location: home.php');
            exit;
            
		}
		else {
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    }
}
  
?>