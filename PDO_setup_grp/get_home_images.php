<?php
		session_start();

		require('connect.php');

		$limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 5;
		
		$offset = $_SESSION["gallery_offset"] * $limit;
		$images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";
		try {
			$stmt = $pdo->prepare($images);
			$stmt->execute();
			$results = $stmt->fetchAll();
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}

		if (count($results) > 0) {
			// $str = '\'<div class="row">';
			$str = '<div class="row">';
			foreach ($results as $res) {
				$src = $res['pic'];
				$str .= '<div class="column">';
				$str .= '<img src = ';
				$str .= $src;
				$str .= ' style="width:90%;"/>';
				$str .= '</div>';
			}
			$str .=  '</div>';
			// $str .=  '<br/>\'';
			$str .=  '<br/>';
		}
		$_SESSION["gallery_offset"] += 1;
		echo $str;
	?>