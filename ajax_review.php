<?php
include_once('db.php');
include_once('script.php');
$s_id = $_GET["s_id"];
$order_id = $_GET["order_id"];
$review = $_GET["review"];
$option = $_GET["option"];  
if ($option == 1) {
    $sql = "insert into s_review (fk_user_id, review, order_id) values($s_id,'$review',$order_id)";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo ("Couldn't Write Review");
    } else {
        echo ("Review Added");
    }   
}       
else if($option == 2){
    if(nextSpin($link, fk_id_to_user_id($link,$s_id))>=0){  
        echo spinComplete($link,fk_id_to_user_id($link,$s_id),$order_id,$review);
    }
    else{
        echo "Invalid Spin, Time Left For Your Next Spin";
    }
}
?>