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
				$str = '<div>' . PHP_EOL;
				foreach ($results as $res) {
					if ($i % 2 == 0) {
						$str .= '<div class="row">' . PHP_EOL;
					}
					$src = $res['pic'];
					$str .= '<div class="column">' . PHP_EOL;
					$str .= '<img src = ';
					$str .= $src;
					$str .= ' onclick="viewImage('.$res['pic_id'].')" id="'.$res['pic_id'].'" style="width:90%;"/>' . PHP_EOL;
					$str .= '</div>';
					if ($i % 2 == 0) {
						$str .= '</div>';
						$str .=  '<br/>';
					}
					$i++;
				}
				// $str .=  '</div>';
				// $str .=  '<br/>';
			}
			$_SESSION["gallery_offset"] += 1;
			echo $str;
		?>
		<p id="responseContainer"></p>
	</div>
	<div>
		<div id="myModal" class="modal">
			<div class= "modal-content">
				<div class="form-wrapper">
					<form action="index.php" method="post" enctype="multipart/form-data">
						<div class="modal-header">
							<h2>Upload<span class="close">&times;</span></h2>
						</div>
						<div class="row">
							<div class="column-right">
								<div style="position: relative; left: 0; top: 0;">
									<img name="image" src="" id='modal-img'>
									<img src="" id="frame" style="position: absolute; top: 1%; left: 12%; width: 75%;"/>
								</div>				
							</div>
							<div class="column-left"><br/></div>
						</div>
						<img name="image" src="" id='modal-img'>
						<p class="upload-font">Title: <input class="upload-box" required type="text" pattern="[^()/><\][\\\x22,;|]+" name="title" id="title"></p>
						<textarea hidden name="base64" id="base64"></textarea>
						<p class="upload-font">Description:  <input class="upload-box" required type="text" pattern="[^()/><\][\\\x22,;|]+" name="description" id="description"></p>
						<br/>
						<button onclick="savePic()" class="btn">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
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

	function viewImage(id) {
		var modal = document.getElementById('myModal');
		var img = document.getElementById('modal-img');
		var span = document.getElementsByClassName("close")[0];

		img.src = document.getElementById(id).src;
		img.setAttribute("width", "100%");
		document.getElementById('base64').value = src;
		modal.style.display = "block";

		// // When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// // When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	}
</script>

</html>