<div>
	<div id="container">
		<div>
			<a href="index.php?logout='1'" class="logo">
				<img src="../img/moustache.png" class="logo" alt="logo" style="width:  40px; height:auti; padding-bottom:10px;">
			</a>
			<br/>
			<a href="index.php?logout='1'" class="logo">
				<img src="../img/cat.png" class="logo" alt="logo" style="width: 40px; height:auto; padding-bottom:10px;">
			</a>
		</div>
		<video autoplay="true" id="videoElement">
		</video>
		<div class="input-group" style="width: 100%; text-align: center; align-content: center;">
			<div id="status"></div>
			<button onclick="takeSnapshot()" class="btn">Snapshot!</button>
			<br/>
			<!-- <button onclick="upload_picture()" class="btn">Upload</button> -->
			<div style="width: 40%; text-align: center; align-content: center; color:white; background-color:rgba(0, 0, 0, 0.7);">
				<input type="file" value="Upload" onchange="upload_picture(); return false;" />
			</div>
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
		var img = document.querySelector('snapshot') || document.createElement('snapshot');
		
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

			canvas = canvas || document.createElement('canvas');
			canvas.width = width;
			canvas.height = height;
			
			context = canvas.getContext('2d');
			context.drawImage(video, 0, 0, width, height);
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
			img.src = document.getElementById("modal-img").src;

			var title = document.getElementById("title").value;
			var descrip = document.getElementById("description").value;
			//Encodes are URI component, encodes special characters
			var pic = (encodeURIComponent(JSON.stringify(img.src)));
			var vars = "username="+usr+"&pic="+pic+"&title="+title+"&descrip="+descrip+"&submit_pic=true";
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
	</script>
</div>