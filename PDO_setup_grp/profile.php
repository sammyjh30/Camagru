<div>
  <div id="scrollContent" style="overflow-y: scroll; height: 500px; width: 100%">
	<div style="height: 500px;">
		<?php
			require('connect.php');

			$limit = 5;
			
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
				$i = 0;
				// $str = '<div class="row">';
				$str = '<div>';
				foreach ($results as $res) {
					if ($i % 2 == 0) {
						$str .= '<div class="row">';
					}
					$src = $res['pic'];
					$str .= '<div class="column">';
					$str .= '<img src = ';
					$str .= $src;
					$str .= ' style="width:90%;"/>';
					$str .= '</div>';
					if ($i % 2 == 0) {
						$str .= '</div>';
						$str .=  '<br/>';
					}
					$i++;
				}
				$str .=  '</div>';
				
				$str .=  '<br/>';
			}
			$_SESSION["gallery_offset"] += 1;
			echo $str;
		?>
	<!-- <div class="row">
		<img src="../img/arrow.gif" alt=”animated” />
		<h3>Scroll down to see what's happening!<h3>
		<img src="../img/arrow.gif" alt=”animated” />
	</div> -->
	<p id="responseContainer"></p>
	</div>
  <div>
<div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded',function () {
		var elm = document.getElementById('scrollContent');
		elm.addEventListener('scroll',callFuntion);
		function callFuntion(){
			var scrollHeight = elm.scrollHeight;
			var scrollTop = elm.scrollTop;
			var clientHeight = elm.clientHeight;

			if(scrollHeight-scrollTop == clientHeight){
				var hr = new XMLHttpRequest();
				var limit = 5;
				var url = "get_home_images.php?limit="+limit;

				hr.open("GET", url);
				hr.addEventListener('readystatechange', handleResponse);
				hr.send();

				function handleResponse() {
					// "this" refers to the object we called addEventListener on
					var hr = this;

					//Exit this function unless the AJAX request is complete,
					//and the server has responded.
					if (hr.readyState != 4)
						return;

					// If there wasn't an error, run our showResponse function
					if (hr.status == 200) {
						var ajaxResponse = hr.responseText;

						showResponse(ajaxResponse);
					}
				}

				function showResponse(ajaxResponse) {
					var responseContainer = document.querySelector('#scrollContent');

					// Create a new span tag to hold the response
					var span = document.createElement('span');
					span.innerHTML = ajaxResponse;

					// Add the new span to the end of responseContainer
					responseContainer.appendChild(span);
				}
			}
		}

	});
</script>

</html>