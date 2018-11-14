
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
        <?php

            require('connect.php');
            $limit = 5;
            $offset = 0;
            
            $images="SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $limit OFFSET $offset";

            try {
                $stmt = $pdo->prepare($images);
                $stmt->execute();
                $results = $stmt->fetchAll();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            if (count($results) > 0) {
            	$str = "<div class='row'>\n";
            	foreach ($results as $res) {
            		$str .= "<div class='column'>\n";
            		$str .= "<img src =".$res['pic']." style='width:90%;'/>\n";
            		$str .= "</div>\n";
            	}
            	$str .=  "</div>\n";
            	$str .=  "<br/>\n";
            }

        ?>



        // for (var i = 0; i < results.length; i++) {
        //     newDiv.innerHTML = results;
        //     // Stuff you would like to do with this array, access elements using gyvuliai_fermoje[i]
        // }
        var string = <?php echo $str ?>
            console.log(string);

      newDiv.innerHTML = string;
    //   newDiv.innerHTML = "my awesome new div";
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
