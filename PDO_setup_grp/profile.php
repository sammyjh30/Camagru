
<div>
	<div id="container">
        <div id="scroll-content">
            <div>test div</div>
        </div>
	</div>
    <div>       
        <button onclick="expand()" class="btn">Next</button>
    </div>
</div>
<script>
var numElementsToAdd = 5,
    offsetForNewContent = 5;

function checkInfiniteScroll(parentSelector, childSelector) {
  var lastDiv = document.querySelector(parentSelector + childSelector),
      lastDivOffset = lastDiv.offsetTop + lastDiv.clientHeight,
      pageOffset = window.pageYOffset + window.innerHeight;

  if(pageOffset > lastDivOffset - offsetForNewContent ) {
    for(var i = 0; i < numElementsToAdd; i++) {
      var newDiv = document.createElement("div");

        // var hr = new XMLHttpRequest();
        // var url = "get_home_images.php";
        // // type: "GET",
        // //   async: false,
        // //   url: "getrecords.php",
        // //   data: "limit=" + lim + "&offset=" + off,
        // //   cache: false,
        //     // var pic = (encodeURIComponent(JSON.stringify(new_img.src)));
			// var vars = "limit="+numElementsToAdd+"&offset="+offsetForNewContent;
		// 	//when changing username, change it in saved image too
			// hr.open("GET", url, true);
			// hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// hr.onreadystatechange = function() {
			// 	if(hr.readyState == 4 && hr.status == 200) {
			// 		var return_data = hr.responseText;
			// 		document.getElementById("status").innerHTML = return_data;
			// 	}
			// }
            // hr.send(vars);
            // var results = <?php //echo $array_encode ?>;
            // for (var i = 0; i < results.length; i++) {
                // Stuff you would like to do with this array, access elements using gyvuliai_fermoje[i]
                // echo"<div class='column'>";
				// echo"<img src =".results[i]['pic']." style='width:90%;'/>";
		// 		echo"</div>";
            // }
            // canvas = canvas || document.createElement('canvas');
        // PDO Connection
        <?php
            // $pdo = new PDO('mysql:host=localhost; dbname=' . $db_name . '; 
            //     charset=utf8mb4', $db_user, $db_password);  
            // $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // // Prepared statement with placeholders
            // $stmt1 = $pdo->prepare("SELECT num FROM tb_zagon_id WHERE status = :status
            //     AND type = :type AND zagon_id = :zagon_id AND user_id = :usid ORDER BY num");

            // // Binding query result to the $num variable (1 is the first column)
            // $stmt1->bindColumn(1, $num);

            // Executing query and replacing placeholders with some variables
            // $stmt1->execute(array(
            //     ':status' => 1,
            //     ':type' => $type_zagon,
            //     ':zagon_id' => $id_kurat,
            //     ':usid' => $usid
            // ));

            // // Creating a PHP array
            // $gyvuliu_array = array();

            require('connect.php');
            $limit = 5;
            // Fetching through the array and inserting query results using $num variable ((int) makes sure a value is an integer)
            while ($stmt1->fetch(PDO::FETCH_ASSOC)) {
                $gyvuliu_array[] = (int)$num;
            }

            // Encoding PHP array so we will be able to use it in the JS code
            $array_encode = json_encode($gyvuliu_array);
    		$images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $limit OFFSET $offset";

        ?>
// <script>
        var gyvuliai_fermoje = <?php echo $array_encode; ?>;

        for (var i = 0; i < gyvuliai_fermoje.length; i++) {
            // Stuff you would like to do with this array, access elements using gyvuliai_fermoje[i]
        }
// </script>


      newDiv.innerHTML = "my awesome new div";
      document.querySelector(parentSelector).appendChild(newDiv);
    }
    checkInfiniteScroll(parentSelector, childSelector);
  }
};

var lastScrollTime = Date.now(), 
    checkInterval = 50;

function update() {
  requestAnimationFrame(update);

  var currScrollTime = Date.now();
  if(lastScrollTime + checkInterval < currScrollTime) {
    checkInfiniteScroll("#scroll-content", "> div:last-child");
    lastScrollTime = currScrollTime;
  }
};

update();
</script>
