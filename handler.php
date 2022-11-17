<?php
function checkTriangle($x, $y, $r) {
    $x1 = 0; $y1 = 0;
    $x2 = $r/2; $y2 = 0;
    $x3 = 0; $y3 = -$r;
    $x0 = $x; $y0 = $y;

    $t1 = ($x1-$x0)*($y2-$y1)-($x2-$x1)*($y1-$y0);
    $t2 = ($x2-$x0)*($y3-$y2)-($x3-$x2)*($y2-$y0);
    $t3 = ($x3-$x0)*($y1-$y3)-($x1-$x3)*($y3-$y0);

    if(checkSameSign($t1, $t2, $t3) || ($t1 == 0 || $t2 == 0 || $t3 == 0)){
        return true;
    }

    return false;
}

function checkSameSign($t1, $t2, $t3){
    if(($t1 > 0 && $t2 > 0 && $t3 > 0) || ($t1 < 0 && $t2 < 0 && $t3 < 0)){
        return true;
    }
    return false;
}

function checkRectangle($x, $y, $r) {
    if ($x >= -$r && $x <= 0){
        return $y >= -$r && $y <= 0;
    }
    return false;
}

function checkCircle($x, $y, $r) {
    if ($y >= 0 && $x >= 0){
        return pow($x, 2) + pow($y, 2) <= pow($r, 2);
    }
    return false;
}

function checkHit($value_x, $value_y, $value_r) {
    return checkCircle($value_x, $value_y, $value_r) || checkRectangle($value_x, $value_y, $value_r) || checkTriangle($value_x, $value_y, $value_r);
}

function getDatetimeWithOffset($offset) {
    $timezone_name = timezone_name_from_abbr("", -$offset*60, false);
    $dt = new DateTime("now", new DateTimeZone($timezone_name));
    return $dt->format("Y-m-d H:i:s");
}

if (isset($_POST["value_R"])){
    $start = microtime(true);
    $x = $_POST["value_X"];
    $y = $_POST["value_Y"];
    $r = $_POST["value_R"];
    $hit = checkHit($x, $y, $r);
    $current_time = getDatetimeWithOffset($_POST["timezone_offset_minutes"]);
    $script_time = (microtime(true) - $start);


    $hit_string = "";
    $class = "";
    if ($hit){
        $hit_string = "Попадание";
        $class = "inside";
    }
    else{
        $hit_string = "Промах";
        $class = "outside";
    }

    echo "<tr class='$class'>
           <td>$x</td> 
           <td>$y</td> 
           <td>$r</td> 
           <td>$hit_string</td> 
           <td>$current_time</td>
           <td>$script_time</td>
           </tr>";

//    echo json_encode(array(
//        "value_X" => $x,
//        "value_Y" => $y,
//        "value_R" => $r,
//        "value_hit" => $hit,
//        "current_time" => $current_time,
//        "script_time_seconds" => $script_time
//    ));
}
