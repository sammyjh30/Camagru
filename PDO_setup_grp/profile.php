<?php

$username = $_SESSION['username'];
?>
<div>
	<div id="container">
		<div class="row">
			<div class="column"></div>
		</div>
	</div>	
</div>
<script>

function takeSnapshot(){
    var new_img = document.createElement("img");
    new_img.src = canvas.toDataURL('image/png');

    new_img.setAttribute("width", "30%");
    new_img.onclick = function() {
        //pop up thing to comment on
        save(new_img.src);
    }
    container2.insertBefore(new_img, container2.firstChild);
}
    
</script>