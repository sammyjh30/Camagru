<?php
		require('connect.php');
		// $page++;
		// $limit = 5;
		// $start = $page * $limit;

		// $images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $start, $limit";
		// $stmt = $pdo->prepare($images);
		// $stmt->execute();
		// $str = "<div class='row'>\n";
		// while ($row = $stmt->fetch()) {
		// 	$str.="<div class='column'\n>";
		// 	$str.="<img src =".$row['pic']." style='width:90%;'/>";
		// 	$str.="</div>";
		// }
		// $str.="</div>";
		// $str.="<br/>";
		// // echo($str);
		// return($str);
// 
// 
		// require_once("config.php");

		$limit = (intval($_GET['limit']) != 0 ) ? $_GET['limit'] : 5;
		$offset = (intval($_GET['offset']) != 0 ) ? $_GET['offset'] : 0;

		$images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $limit OFFSET $offset";
		// $sql = "SELECT countries_name FROM countries WHERE 1 ORDER BY countries_name ASC LIMIT $limit OFFSET $offset";
		try {
			$stmt = $pdo->prepare($images);
			$stmt->execute();
			$results = $stmt->fetchAll();
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
		if (count($results) > 0) {
			echo "<div class='row'>";
			foreach ($results as $res) {
				echo"<div class='column'>";
				echo"<img src =".$res['pic']." style='width:90%;'/>";
				echo"</div>";
				// echo '<h3>' . $res['countries_name'] . '</h3>';
			}
			echo "</div>";
			echo "<br/>";
		}
	?>