<div>
    <?php

        if (isset($_POST['change_settings'])) {
            //Retrieve the field values from our registration form.
            $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $name = !empty($_POST['name']) ? trim($_POST['name']) : null;
            $surname = !empty($_POST['surname']) ? trim($_POST['surname']) : null;
            $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $password_1 = !empty($_POST['password_1']) ? trim($_POST['password_1']) : null;
            $password_2 = !empty($_POST['password_2']) ? trim($_POST['password_2']) : null;

            // if (empty($username)) { array_push($errors, "Username is required"); }
            // if (empty($name)) { array_push($errors, "Name is required"); }
            // if (empty($surname)) { array_push($errors, "Surname is required"); }
            // if (empty($email)) { array_push($errors, "Email is required"); }
            // if (empty($password_1)) { array_push($errors, "Password is required"); }
            if (empty($password_2) && !empty($password_1)) { array_push($errors, "Password confirmation is required"); }
            if ($password_1 != $password_2) { array_push($errors, "Your two passwords do not match"); }
            
            if (count($errors) == 0) {
                $_SESSION['username'] = $username;
                try
                {
                    if (!empty($username)) {
                        $sql = "UPDATE camagru_db.users SET username='".$username."' WHERE username='".$_SESSION['username']."'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                    }
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

                // $base_url = "http://localhost:8080/Camagru/PDO_setup_grp/";
                // $lastInsertId = $pdo->lastInsertId();
                // if($lastInsertId) {
                //     $msg = "You have signed up Successfully";

                //     $header = "From: noreply@localhost.co.za\r\n";
                //     $header .= "Reply-To: noreply@localhost.co.za\r\n";
                //     $header .= "Return-Path: noreply@localhost.co.za\r\n";
                //     $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                //     $message = "<h1>Activate Your Account</h1><br/>
                //                 <p>Hello $username,</p>
                //                 <p>Thank you for registering to Camagru! Your username and password will work only after your email verification.</p>
                //                 <p>Please click on the button below to verify your email address:</p><br/>
                //                 <p><a href='" . $base_url . "confirm_email.php?username=$username&activation_code=$activation_code'>
                //                 <button>Verify</button>
                //                 </a></p>
                //                 <p>Best Regards,<br />Camagru</p>";
                //     if (mail($email, "Activation email", $message, $header) == false)
                //         echo "Error when sending email<br/>";
                //     else
                //         echo "email sent<br/>";
                //     $_SESSION['message'] = "Check your email for the Activation Link.";
                //     unset($_SESSION['username']);
                // }
                else {
                    $error="Something went wrong.Please try again";
                    $_SESSION['error'] = $error;
                }
                unset($_SESSION['window']);
                header('Location: index.php');
            }
        }

    ?>
    <form method="post" action="settings.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Change Username</label>
            <input type="text" name="username" value="<?php $username; ?>">
        </div>
        <div class="input-group">
            <label>Change Name</label>
            <input type="text" name="name" value="<?php $name; ?>">
        </div>
        <div class="input-group">
            <label>Change Surname</label>
            <input type="text" name="surname" value="<?php $surname; ?>">
        </div>
        <div class="input-group">
            <label>Change Email</label>
            <input type="text" name="email" type=“email” value="<?php $email; ?>">
        </div>
        <div class="input-group">
            <label>Change Password</label>
            <input type="password" onchange=”this.setCustomValidity(this.validity.patternMismatch ? ‘Must have at least 4 characters’ : ”); if(this.checkValidity()) form.password_two.pattern = this.value;” name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div>
            <label>Receive Email Notifications for Comments</label>
            <label class="switch">
                <input type="checkbox" checked="true" class="checkbox">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="change_settings" style="font-size:90%; padding:1%;">Save Changes</button>
        </div>
    </form>
</div>
