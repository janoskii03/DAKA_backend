<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=utf-8");

try {
    $postData = json_decode(file_get_contents('php://input'), true);
    require_once("connectDaka.php");

    if (isset($postData["order_id"])) {
        $order_id = $postData["order_id"];
        $newStatus = 3; // 設定新的狀態值
        $sql = "UPDATE comics_order SET comics_order_status = :new_status WHERE comics_order_id = :order_id";
        $comics_order = $pdo->prepare($sql);
        $comics_order->bindValue(":new_status", $newStatus);
        $comics_order->bindValue(":order_id", $order_id);
        $comics_order->execute();
        
        echo 'success';
    } else {
        echo 'Invalid data';
    }
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>
