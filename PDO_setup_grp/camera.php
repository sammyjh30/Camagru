<div>
	<div id="container">
		<video autoplay="true" id="videoElement">
		</video>
		<div class="input-group" style="width: 100%; text-align: center; align-content: center;">
			<div id="status"></div>
			<button onclick="takeSnapshot()" class="btn">Snapshot!</button>
			<button onclick="upload_picture()" class="btn">Upload!</button>
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
                img2.onload = function () {
                    canvas.getContext('2d').drawImage(img2,0, 0, width, height);
                }
                img2.src = reader.result;
                document.getElementById("container2").innerHTML = "<img style='width:100%; height:100%;'src="+img2.src+">";
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