<div>
  <h3>Infinite Scroll Example</h3>
  <div id="scrollContent" style="overflow-y: scroll; height: 500px; width: 100%">
    <div style="height: 500px; background-color: red">
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
        <?php
            require('connect.php');
            $limit = 5;
            global $offset;
            if(empty($offset)){
                $offset = 0;
                // echo 'This line is printed, because the $var2 is empty.';
            }
            $start = $offset * $limit;
            // $images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT ".$limit." OFFSET ".$offset."";
            $images = "SELECT `username`,`pic`,`pic_id` FROM pictures ORDER BY sub_datetime DESC LIMIT $start, $limit ";
            try {
                $stmt = $pdo->prepare($images);
                $stmt->execute();
                $results = $stmt->fetchAll();
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            $offset++;
            $off = $offset;
            echo "var off = $off;";

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
            echo "var string = $str;"; 
        ?>
        elm.innerHTML += off;
        elm.innerHTML += string;
        // elm.innerHTML += '<div style="height: 300px; background-color: blue"> New Element Added </div>' ;
      }
    }

  });
</script>

</html>