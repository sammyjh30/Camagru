
<div>
	<div id="container">
		<div class="row">
			<div class="column">
                <?php
                require('connect.php');

                // $username = $_SESSION['username'];

                // $images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $starting_limit, $limit ";
                $images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime";
                $stmt = $pdo->prepare($images);
                $stmt->execute();
                // echo $stmt;
                error_log($stmt->fetch()['pic']);
                // while ($row = $stmt->fetch()) {
                //     echo('<img src ='.$row['pic'].'/>');
                // }
                ?>
            </div>
		</div>
	</div>	
</div>
<script>

// function takeSnapshot(){
//     var new_img = document.createElement("img");
//     new_img.src = canvas.toDataURL('image/png');

//     new_img.setAttribute("width", "30%");
//     new_img.onclick = function() {
//         //pop up thing to comment on
//         save(new_img.src);
//     }
//     container2.insertBefore(new_img, container2.firstChild);
// }
    
</script>