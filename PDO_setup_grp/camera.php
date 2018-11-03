<div>
<!-- <!DOCTYPE html> -->
<!-- <html> -->
	<!-- <div> -->
<!-- <script>
	var video = document.querySelector("#videoElement"), canvas;
	var img = document.querySelector('img') || document.createElement('img');
		
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
		document.getElementById("container2").innerHTML = "<img src="+img.src+">";
		//document.body.appendChild(img);
		}
	function savePic(){
		var hr = new XMLHttpRequest();
		var url = "server.php";
		var usr = ' //echo $_SESSION["username"]; ?>';
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
	</script> -->
<!-- <head>
<meta charset="utf-8">
<meta content="stuff, to, help, search, engines, not" name="keywords">
<meta content="What this page is about." name="description">
<meta content="Display Webcam Stream" name="title">
<title>Display Webcam Stream</title>
   -->
<!-- </head> -->
  
<!-- <body> -->
<div id="container">
    <video autoplay="true" id="videoElement">
     
    </video>
</div>
<script>
	var video = document.querySelector("#videoElement");
	
	if (navigator.mediaDevices.getUserMedia) {       
		navigator.mediaDevices.getUserMedia({video: true})
	.then(function(stream) {
		video.srcObject = stream;
	})
	.catch(function(err0r) {
		console.log("Something went wrong!");
	});
	}
</script>
<!-- </body> -->
<!-- <video autoplay="true" id="videoElement"> -->
 
<!-- </video> -->
</div>
<!-- </html> -->