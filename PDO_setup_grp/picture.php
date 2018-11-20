<?php
		session_start();

		require('connect.php');
        
        // $pic_id = $_GET['pic_id'];
		
		// $offset = $_SESSION["gallery_offset"] * $limit;
		// $pic = "SELECT 'likes' FROM pictures WHERE pic_id = :pic_id";
		// try {
		// 	$stmt = $pdo->prepare($pic);
		// 	$stmt->execute(["likes"=>$likes]);
		// 	$results = $stmt->fetchAll();
		// } catch (Exception $ex) {
		// 	echo $ex->getMessage();
		// }
        // echo "123";

        $pic_id = $_GET['pic_id'];
        // echo $pic_id;
        $stmt = $pdo->prepare("SELECT likes FROM camagru_db.pictures WHERE pic_id=".$pic_id);
        // echo $stmt;
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str = '<div id="likeBox" style="background-color:rgb(255, 255, 255); padding: 2%; display: inline; border-radius: 5px;">';
            $str .= $row['likes'];
            $str .= '</div>';
            $str .= '<button onclick="likePic()" class="btn">Like</button>';
            $str .= '<br/>';
        }
        
        $str .= '<div id="comment-box" style="background-color:rgb(255, 255, 255); padding: 5%;">';
        
        $stmt = $pdo->prepare("SELECT title FROM camagru_db.pictures WHERE pic_id=".$pic_id);
        // echo $stmt;
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str .= '<div style="display: inline; font-size: 70%; font-weight: bold; padding-right: 5px;">';
            $str .= $row['title'];
            $str .= '</div>';
        }

        $stmt = $pdo->prepare("SELECT description FROM camagru_db.pictures WHERE pic_id=".$pic_id);
        // echo $stmt;
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str .= '<div style="display: inline; font-size: 70%;">';
            $str .= $row['description'];
            $str .= '</div>';
        }

        $str .= '<div id="comments">';
        $stmt = $pdo->prepare("SELECT comment FROM camagru_db.comments WHERE pic_id=".$pic_id." ORDER BY sub_datetime DESC LIMIT 5");
        // echo $stmt;
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $str .= ($row['comment']);
            $str .= "<br>";
        }
        $str .= '</div>';
        $str .= '<br/>';
        $str .= '<textarea hidden name="base64" id="base64"></textarea>';
        $str .= '<p class="upload-font"><input class="upload-box" required type="text" pattern="[^()/><\][\\\x22,;|]+" name="comment" id="comment"  style="display: inline"></p>';
        $str .= '<button onclick="commentPic()" class="btn"  style="display: inline">Comment</button>';
        $str .= '</div>';
       
        echo $str;
	?>