
<!-- <div> -->
	<!-- <div id="container_gal"> -->
        <!-- <div id="scroll-content"> -->
            <!-- <div>test div</div> -->
        <!-- </div> -->
	<!-- </div> -->
    <!-- <div>       
        <button onclick="expand()" class="btn">Next</button>
    </div> -->
<!-- </div> -->
<script>
// var numElementsToAdd = 1,
//     offsetForNewContent = 1;

// function checkInfiniteScroll(parentSelector, childSelector) {
//     var lastDiv = document.querySelector(parentSelector + childSelector),
//         lastDivOffset = lastDiv.offsetTop + lastDiv.clientHeight,
//         pageOffset = window.pageYOffset + window.innerHeight;
//         // field = getElementById("container"),
//         // pageOffset = field.pageYOffset + field.innerHeight;

//     if(pageOffset > lastDivOffset - offsetForNewContent ) {
//         // for(var i = 0; i < numElementsToAdd; i++) {
//             var newDiv = document.createElement("div");
            <?php

                // require('connect.php');
                // $limit = 5;
                // $offset = 0;
                // $images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";
                // try {
                //     $stmt = $pdo->prepare($images);
                //     $stmt->execute();
                //     $results = $stmt->fetchAll();
                // } catch (Exception $ex) {
                //     echo $ex->getMessage();
                // }
                // $offset = $offset + $limit;

                // // $str = (count($results));
                // if (count($results) > 0) {
                //     $str = '\'<div class="row">';
                //     foreach ($results as $res) {
                //         $src = $res['pic'];
                //         $str .= '<div class="column">';
                //         $str .= '<img src = ';
                //         $str .= $src;
                //         $str .= ' style="width:90%;"/>';
                //         $str .= '</div>';
                //     }
                //     $str .=  '</div>';
                //     $str .=  '<br/>\'';
                // }
                // echo "</script><script type='text/javascript'>var string = $str;</script><script>"; 
            ?>
            // var string = <?php //echo $str ?>;
//             newDiv.innerHTML = string;
//             //  newDiv.innerHTML = "my awesome new div";
//             document.querySelector(parentSelector).appendChild(newDiv);
//         // }
//         checkInfiniteScroll(parentSelector, childSelector);
//     }
// };

// var lastScrollTime = Date.now(), 
//     checkInterval = 50;

// function update() {
//   requestAnimationFrame(update);

//   var currScrollTime = Date.now();
//   if(lastScrollTime + checkInterval < currScrollTime) {
//     checkInfiniteScroll("#scroll-content", "> div:last-child");
//     lastScrollTime = currScrollTime;
//   }
// };

// update();
</script>

<!-- <html>
<head>
<title>Infinite Scroll</title>
</head>
<body> -->
<div>
  <h3>Infinite Scroll Example</h3>
  <div id="scrollContent" style="overflow-y: scroll; height: 100px; width: 500px">
    <div style="height: 300px; background-color: red">
    </div>
  <div>
<div>
<!-- </body> -->

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded',function () {
    var elm = document.getElementById('scrollContent');
    elm.addEventListener('scroll',callFuntion);

    function callFuntion(){
      var scrollHeight = elm.scrollHeight;
      var scrollTop = elm.scrollTop;
      var clientHeight = elm.clientHeight;

      if(scrollHeight-scrollTop == clientHeight){
        <?php
            require('connect.php');
            $limit = 5;
            $offset = 0;
            $images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";
            try {
                $stmt = $pdo->prepare($images);
                $stmt->execute();
                $results = $stmt->fetchAll();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            $offset = $offset + $limit;

            // $str = (count($results));
            if (count($results) > 0) {
                $str = '\'<div class="row">';
                foreach ($results as $res) {
                    $src = $res['pic'];
                    $str .= '<div class="column">';
                    $str .= '<img src = ';
                    $str .= $src;
                    $str .= ' style="width:90%;"/>';
                    $str .= '</div>';
                }
                $str .=  '</div>';
                $str .=  '<br/>\'';
            }
            echo "</script><script type='text/javascript'>var string = $str;</script><script>"; 
        ?>
        var string = <?php //echo $str ?>;
        elm.innerHTML += string;
        // elm.innerHTML += '<div style="height: 300px; background-color: blue"> New Element Added </div>' ;
      }
    }

  });
</script>

</html>