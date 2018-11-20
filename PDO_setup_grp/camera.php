<div>
	<div id="container">
		<div class="row">
			<div class="column-left">
				<table style="width:100%">
					<tr style="width:100%; height:100%;">
						<br/>
						<div class="myButton">
							<input type="image" src="../img/moustache.png" onclick="overlay(0)" class="logo" alt="logo" style="width:100%; height:auto; padding:10px 0px 10px 0px;">
						</div>
						<br/>
					</tr>
					<tr>
						<br/>
						<div class="myButton">
							<input type="image" src="../img/cat.png" onclick="overlay(1)" class="logo" alt="logo" style="width:100%; height:auto; padding:10px 0px 10px 0px;">
						</div>
						<br/>
					</tr>
				</table>
				<br/>
			</div>
			<div class="column-right">
				<div style="position: relative; left: 0; top: 0;">
					<video autoplay="true" id="videoElement" style="position:relative; top:0; left:0;"></video>
					<img src="../img/moustache.png" id="filter" style="position: absolute; top: 60%; left: 40%; width: 25%;"/>
				</div>				
				<div class="input-group" style="width: 100%; text-align: center; align-content: center;">
					<div id="status"></div>
					<button onclick="takeSnapshot()" class="btn" style="font-size:90%; padding:1%;">Snapshot!</button>
					<br/>
					<div style="margin: auto; width: 40%; text-align: center; align-content: center; color:white; background-color:rgba(0, 0, 0, 0.7);">
						<input type="file" value="Upload" onchange="upload_picture(); return false;" />
					</div>
				</div>
			</div>
			<div class="column-left"><br/></div>
		</div>
	</div>
	<br/><br/>
	<div id="container2" class="container2"></div>
	<div id="myModal" class="modal">
		<div class= "modal-content">
		<div class="form-wrapper">
			<form action="index.php" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h2>Upload<span class="close">&times;</span></h2>
				</div>
				<div class="row">
					<div class="column-left">
						<table style="width:100%">
							<tr style="width:100%; height:100%;">
								<br/>
								<div class="myButton">
									<input type="image" src="../img/frame.png" onclick="addFrame()" class="logo" alt="logo" style="width:100%; height:auto; padding:10px 0px 10px 0px;">
								</div>
								<br/>
							</tr>
						</table>
						<br/>
					</div>
					<div class="column-right">
						<div style="position: relative; left: 0; top: 0;">
							<img name="image" src="" id='modal-img'>
							<img src="" id="frame" style="position: absolute; top: 1%; left: 12%; height:75%; width:auto;"/>
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
	<script>
		var video = document.querySelector("#videoElement"), canvas;
		var filter = document.getElementById('filter');
		var frame = document.getElementById('frame');
		var img = document.querySelector('snapshot') || document.createElement('snapshot');
		var fx = 0;
		var fy = 0;
		var frm = 0;

		if (navigator.mediaDevices.getUserMedia) {       
			navigator.mediaDevices.getUserMedia({video: true})
			.then(function(stream) {
				video.srcObject = stream;
				return video.play(); // returns a false Promise
			})
		}
		function takeSnapshot(){
			var new_img = document.createElement("img");
			var context;
			var width = video.offsetWidth, height = video.offsetHeight;
			var f_width = filter.offsetWidth, f_height = filter.offsetHeight;

			if (f_width == 0) { f_width = filter.offsetWidth; }
			if (f_height == 0) { f_height = filter.offsetHeight; }
			if (fx == 0) { fx = width/100 * 40; }
			if (fy == 0) { fy = height/100 * 60; }
			

			canvas = canvas || document.createElement('canvas');
			canvas.width = width;
			canvas.height = height;
			
			context = canvas.getContext('2d');
			context.globalAlpha = 1.0;
			context.drawImage(video, 0, 0, width, height);
			context.drawImage(filter, fx, fy, f_width, f_height);
			new_img.src = canvas.toDataURL('image/png');

			new_img.setAttribute("width", "30%");
			new_img.onclick = function() {
				save(new_img.src);
			}
			container2.insertBefore(new_img, container2.firstChild);
		}

		function upload_picture() {

			var context;
			var width = video.offsetWidth, height = video.offsetHeight;

			canvas = canvas || document.createElement('canvas');
			canvas.width = width;
			canvas.height = height;

			var file = document.querySelector('input[type=file]').files[0];
			var reader  = new FileReader();

			reader.onloadend = function () {
				var img2 = new Image();
				var new_img = document.createElement("img");
				var context;

				context = canvas.getContext('2d');
				context.drawImage(img2, 0, 0, width, height);
				img2.src = reader.result;

				img2.setAttribute("width", "30%");
				img2.onclick = function() {
					save(img2.src);
				}
				container2.insertBefore(img2, container2.firstChild);
			};
			reader.readAsDataURL(file);
		}

		function save(src) {
			var modal = document.getElementById('myModal');
			var img = document.getElementById('modal-img');
			var span = document.getElementsByClassName("close")[0];

			img.src = src;
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

		// Save picture
		function savePic(){
			var hr = new XMLHttpRequest();
			var url = "server.php";
			var usr = '<?php echo $_SESSION["username"]; ?>';

			var img = document.getElementById("modal-img");
			var new_img = document.createElement("img");
			var context;
			var img_width = img.offsetWidth, img_height = img.offsetHeight;
			var frame_width = frame.offsetWidth;
			var frame_height = frame.offsetHeight;

			canvas = canvas || document.createElement('canvas');
			canvas.width = img_width;
			canvas.height = img_height;
			
			context = canvas.getContext('2d');
			context.globalAlpha = 1.0;
			context.drawImage(img, 0, 0, img_width, img_height);
			context.drawImage(frame, (img_width/100 * 12), (img_height/100 * 1), frame_width, frame_height);
			new_img.src = canvas.toDataURL('image/png');

			var title = document.getElementById("title").value;
			var descrip = document.getElementById("description").value;
			//Encodes are URI component, encodes special characters
			var pic = (encodeURIComponent(JSON.stringify(new_img.src)));
			var vars = "username="+usr+"&pic="+pic+"&title="+title+"&descrip="+descrip+"&submit_pic=true";
			//when changing username, change it in saved image too
			hr.open("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function() {
				if(hr.readyState == 4 && hr.status == 200) {
					var return_data = hr.responseText;
					document.getElementById("status").innerHTML = return_data;
				}
			}
			hr.send(vars);
			document.getElementById("status").innerHTML = "processing...";
		}

		function overlay(num) {
			var img = document.getElementById('filter');
			if (num == 1) {
				//cat ears
				img.src = "../img/cat.png";
				img.style.width = '40%';
				img.style.top = '20%';
				img.style.left = '30%';
				fx = video.offsetWidth/100 * 29;
				fy = video.offsetHeight/100 * 20;
			}
			else {
				//moustache
				img.src = "../img/moustache.png";
				img.style.width = '25%';
				img.style.top = '60%';
				img.style.left = '40%';
				fx = video.offsetWidth/100 * 40;
				fy = video.offsetHeight/100 * 60;
			}
		}

		function addFrame() {
			//
			if (frm == 0) {
				frm = 1;
				frame.src = "../img/frame.png";
			}
			else {
				frm = 0;
				frame.src = "";
			}
		}
	</script>
</div>