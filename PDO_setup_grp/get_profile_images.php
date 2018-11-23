<?php
		session_start();

		require('connect.php');

        $limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 6;
        $username = $_SESSION['username'];
		
        $offset = $_SESSION["gallery_offset"] * $limit;
		$images = "SELECT `username`,`pic`,`pic_id` FROM pictures WHERE username='$username' ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";        
		try {
			$stmt = $pdo->prepare($images);
			$stmt->execute();
			$results = $stmt->fetchAll();
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}

		if (count($results) > 0) {
			$i = 0;
			$str = '<div>' . PHP_EOL;
			foreach ($results as $res) {
				if ($i % 2 == 0) {
					$str .= '<div class="row">' . PHP_EOL;
				}
				$src = $res['pic'];
				$str .= '<div class="column">' . PHP_EOL;
				$str .= '<img src = ';
				$str .= $src;
				$str .= ' onclick="viewImage('.$res['pic_id'].')" id="';
				$str .= $res['pic_id'].'" name="'.$res['username'].'" style="width:90%;"/>' . PHP_EOL;
				$str .= '</div>';
				$i++;
				if ($i % 2 == 0) {
					$str .= '</div>';
					$str .=  '<br/>';
				}
			}
			$str .=  '</div>';
			$str .=  '<br/>';
		}
		$_SESSION["gallery_offset"] += 1;
		echo $str;
	?>