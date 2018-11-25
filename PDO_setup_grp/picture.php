<?php
		session_start();

		require('connect.php');
        $pic_id = $_GET['pic_id'];

        if(isset($_GET['open_pic']) && isset($_SESSION['username'])){
            //Likes & delete
            $stmt = $pdo->prepare("SELECT * FROM camagru_db.pictures WHERE pic_id=".$pic_id);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $str = '<div id="likeBox" style="background-color:rgb(255, 255, 255); padding: 2%; display: inline; border-radius: 5px;">';
                $str .= $row['likes'];
                $str .= '</div>';
                $str .= '<input type="button" onclick="likePic('.$pic_id.')" class="btn" value="Like" style="width:20%;">';
                if ($row['username'] == $_SESSION['username']) {
                    $str .= '<div style="display: inline; padding-left: 4em;"><input type="button" onclick="deletePic('.$pic_id.')" class="btn" value="Delete" style="width:20%;"></div>';
                }
                $str .= '<br/>';
            }
            
            //Title
            $str .= '<div id="comment-box" style="background-color:rgb(255, 255, 255); padding: 5%; border-radius: 5px;">';
            
            $stmt = $pdo->prepare("SELECT title FROM camagru_db.pictures WHERE pic_id=".$pic_id);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $str .= '<div style="display: inline; font-size: 70%; font-weight: bold; padding-right: 5px;">';
                $str .= $row['title'];
                $str .= '</div>';
            }

            //Description
            $stmt = $pdo->prepare("SELECT description FROM camagru_db.pictures WHERE pic_id=".$pic_id);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $str .= '<div style="display: inline; font-size: 70%;">';
                $str .= $row['description'];
                $str .= '</div>';
            }

            //Comments
            $str .= '<div id="comments">';
            $stmt = $pdo->prepare("SELECT * FROM camagru_db.comments WHERE pic_id=".$pic_id." ORDER BY sub_datetime DESC LIMIT 5");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $str .= '<div style="display: inline; font-size: 70%; font-weight: bold; padding-right: 5px;">';
                $str .= ($row['username']);
                $str .= '</div>';
                $str .= '<div style="display: inline; font-size: 70%;">';
                $str .= ($row['comment']);
                $str .= '</div>';
                $str .= "<br>";
            }
            $str .= '</div>';
            $str .= '<br/>';
            $str .= '<input type="text" maxlength="56" name="comment" id="comment" style="width:60%; padding: 10px;">';
            $str .= '<input type="button" onclick="commentPic('.$pic_id.')" class="btn" value="Comment" style="font-size:small; width: 30%">';
            $str .= '</div>';
        
            echo $str;
    }

    if(isset($_GET['like_pic'])){
        $sql = "UPDATE camagru_db.pictures SET likes = likes + 1 WHERE pic_id = $pic_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT likes FROM camagru_db.pictures WHERE pic_id=".$pic_id);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str = $row['likes'];
        }
        echo $str;
    }

    function cleanInput($value)
	{
        $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );
    
        $output = preg_replace($search, '', $value);
        return $output;
	}

    if(isset($_GET['comment_pic'])){
        
        $comment = cleanInput($_GET['comment']);
        $comment = addslashes($comment);

        $username = $_SESSION['username'];
        $sql = "INSERT INTO camagru_db.comments (pic_id, username, comment) VALUES ('$pic_id', '$username', '$comment')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT username FROM camagru_db.pictures WHERE pic_id=$pic_id");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $username = $row['username'];
        }

        //Check if email notification is on
        $sql = "SELECT notify FROM camagru_db.users WHERE username='".$username."'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();
        if ($results['notify'] === "Y") { 
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username='$username'");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $email = $row['email'];
            }


            //Send email
            $base_url = "http://localhost:8080/Camagru/PDO_setup_grp/";

            $header = "From: noreply@localhost.co.za\r\n";
            $header .= "Reply-To: noreply@localhost.co.za\r\n";
            $header .= "Return-Path: noreply@localhost.co.za\r\n";
            $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = "<h1>Your Post Got A Comment!</h1><br/>
                        <p>Hello $username,</p>
                        <p>Someone has commented on your post!.</p>
                        <p>Click here to go check it out!</p><br/>
                        <p><a href='" . $base_url . "index.php'>
                        <button>Camagru</button>
                        </a></p>
                        <p>Best Regards,<br/>Camagru</p>";
            if (mail($email, "Your Post Got A Comment!", $message, $header) == false) {
                // echo "Error when sending email<br/>";
            }
            else {
                // echo "email sent<br/>";
            }
        }

        $str = '';
        $stmt = $pdo->prepare("SELECT * FROM camagru_db.comments WHERE pic_id=".$pic_id." ORDER BY sub_datetime DESC LIMIT 5");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str .= '<div style="display: inline; font-size: 70%; font-weight: bold; padding-right: 5px;">';
            $str .= ($row['username']);
            $str .= '</div>';
            $str .= '<div style="display: inline; font-size: 70%;">';
            $str .= ($row['comment']);
            $str .= '</div>';
            $str .= "<br>";
        }
        echo $str;
    }

    if(isset($_GET['delete_pic'])){

		$sql = "DELETE FROM pictures WHERE pic_id = $pic_id;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
    }
	?>