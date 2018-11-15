<?php
		require('connect.php');

		$limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 5;
		$offset = (intval($_GET['offset']) != 0 ) ? $_GET['offset'] : 0;

		$images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";
		try {
			$stmt = $pdo->prepare($images);
			$stmt->execute();
			$results = $stmt->fetchAll();
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
		// $offset++;
		$off = $offset;
		echo "var off = $off;";

		// $str = (count($results));
		if (count($results) > 0) {
			$str = '\'<div class="row">';
			foreach ($results as $res) {
				$src = $res['pic'];
				$str .= '<div class="column">';
				$str .= '<img src = ';
				$str .= $src;
				$str .= ' style="width:90%;"/>';
				$str .= '</div>';
			}
			$str .=  '</div>';
			$str .=  '<br/>\'';
		}
		echo "var string = $str;"; 
	?>