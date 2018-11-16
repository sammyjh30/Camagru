<div>
  <h3>Infinite Scroll Example</h3>
  <div id="scrollContent" style="overflow-y: scroll; height: 500px; width: 100%">
	<div style="height: 500px;">
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