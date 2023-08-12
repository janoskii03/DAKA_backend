<?php
// updateOrderStatus.php
header('Access-Control-Allow-Origin:*');
header("Content-Type: application/json; charset=utf-8");

try {
    $postData = json_decode(file_get_contents("php://input"));
    require_once("connectDaka.php");

    $order_id = $postData->order_id; 
    $newStatus = $postData->new_status;

    $sql = "UPDATE comics_order SET comics_order_status = :new_status WHERE comics_order_id = :order_id"; // 使用 :order_id 而不是 :comics_order_id
    $comics_order = $pdo->prepare($sql);
    $comics_order->bindValue(':new_status', $newStatus);
    $comics_order->bindValue(':order_id', $order_id);
    $comics_order->execute();
    
    echo 'success';
} catch (PDOException $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
?>
