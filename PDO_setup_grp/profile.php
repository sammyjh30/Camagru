<div>
  <div id="scrollContent" style="overflow-y: scroll; height: 500px; width: 100%">
	<div style="height: 500px;">
		<?php
			require('connect.php');

			$limit = 6;
			
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
		<p id="responseContainer"></p>
	</div>
	<div>
		<div id="myModal" class="modal">
			<div class= "modal-content" style="height:70%;">
				<div class="form-wrapper" style="width:100%;">
					<form action="index.php" method="post" enctype="multipart/form-data">
						<div class="modal-header">
							<h2>
								<div id="user" style="width:30%; display: inline; font-size: 70%;"></div>
								<span class="close">&times;</span>
							</h2>
						</div>
						<img name="image" src="" id='modal-img' style="margin:auto; height:100%; width:90%; text-align: center; align-content: center;">
						<br/>
						<div id="pic_info">
						</div>
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
				var limit = 6;
				var url = "get_home_images.php?limit="+limit;

				hr.open("GET", url);
				hr.addEventListener('readystatechange', handleResponse);
				hr.send();

				function handleResponse() {
					// "this" refers to the object we called addEventListener on
					var hr = this;

					//Exit this function unless the AJAX request is complete, and the server has responded.
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
		var mod_img = document.getElementById(id);
		var src = document.getElementById(id).src;

		img.src = src;
		img.setAttribute("width", "100%");
		// document.getElementById('base64').value = src;
		modal.style.display = "block";
		
		document.getElementById('user').innerHTML = mod_img.name;

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}

		//getting like and comment section
		var info = document.getElementById('pic_info');
		var mod_aj = new XMLHttpRequest();
		var url = "picture.php?open_pic=1&pic_id="+id;

		mod_aj.open("GET", url);
		mod_aj.addEventListener('readystatechange', handleResponse);
		mod_aj.send();

		function handleResponse() {
			// "this" refers to the object we called addEventListener on
			var mod_aj = this;

			//Exit this function unless the AJAX request is complete, and the server has responded.
			if (mod_aj.readyState != 4)
				return;

			// If there wasn't an error, run our showResponse function
			if (mod_aj.status == 200) {
				var ajaxResponse = mod_aj.responseText;

				showResponse(ajaxResponse);
			}
		}

		function showResponse(ajaxResponse) {
			var responseContainer = document.querySelector('#scrollContent');
			info.innerHTML = ajaxResponse;
		}
	}

	function likePic(id) {
		var like_aj = new XMLHttpRequest();
		var url = "picture.php?like_pic=1&pic_id="+id;

		like_aj.open("GET", url);
		like_aj.addEventListener('readystatechange', handleResponse);
		like_aj.send();

		function handleResponse() {
			// "this" refers to the object we called addEventListener on
			var like_aj = this;

			//Exit this function unless the AJAX request is complete, and the server has responded.
			if (like_aj.readyState != 4)
				return;

			// If there wasn't an error, run our showResponse function
			if (like_aj.status == 200) {
				var ajaxResponse = like_aj.responseText;

				showResponse(ajaxResponse);
			}
		}

		function showResponse(ajaxResponse) {
			var responseContainer = document.querySelector('#likeBox');
			responseContainer.innerHTML = ajaxResponse;
		}
	}
</script>

</html>