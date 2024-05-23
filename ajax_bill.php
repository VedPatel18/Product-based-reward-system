<?php
include_once('db.php');
include_once('script.php');
$s_id = $_GET["s_id"];
$order_value = $_GET["order_value"];
$option = $_GET["option"];
if($option == 1){
    echo json_encode(usePoints($link,fk_id_to_user_id($link,$s_id),$order_value));
}
else if($option == 2){
    $sql = "insert into s_orders (fk_user_id, amount) values($s_id, $order_value)";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo ("Couldn't place order");
    } else {
        echo ("Order Placed");
    }
}
else if($option == 3){
    echo json_encode(getUserRewardPoints($link,fk_id_to_user_id($link,$s_id)));
}
else if($option == 4){  
    echo json_encode(getUserPremiumDays($link,fk_id_to_user_id($link,$s_id)));
}   
else if($option == 5){
    echo activeSpins($link);
}
else if($option == 6){
    echo nextSpin($link, fk_id_to_user_id($link,$s_id));
}
?>