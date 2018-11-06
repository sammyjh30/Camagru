<div>
	<div id="container">
		<video autoplay="true" id="videoElement">
		</video>
		<div class="input-group" style="width: 100%; text-align: center; align-content: center;">
			<div id="status"></div>
			<button onclick="takeSnapshot()" class="btn">Take pic</button>
			<button onclick="savePic()" class="btn">Save</button> 
		</div>
	</div>
	<br/><br/>
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
			var context;
			var width = video.offsetWidth, height = video.offsetHeight;

			canvas = canvas || document.createElement('canvas');
			canvas.width = width;
			canvas.height = height;
			
			context = canvas.getContext('2d');
			context.drawImage(video, 0, 0, width, height);
			img.src = canvas.toDataURL('image/png');
			document.getElementById("container2").innerHTML = "<img src="+img.src+" alt='snapshot' style='border:10px solid rgba(255, 255, 255, 0.2); width:60%; height:auto;'>";
		}

		// Save picture
		function savePic(){
			var hr = new XMLHttpRequest();
			var url = "server.php";
			var usr = '<?php echo $_SESSION["username"]; ?>';
			//Encodes are URI component, encodes special characters
			var pic = (encodeURIComponent(JSON.stringify(img.src)));
			var vars = "username="+usr+"&pic="+pic+"&submit_pic=true";
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