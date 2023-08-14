<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=utf-8");

try {
    $postData = json_decode(file_get_contents('php://input'), true);
    require_once("connectDaka.php");

    if (isset($_POST["comics_id"])) {
        $comics_id = $_POST["comics_id"];
        $newStatus = $_POST["new_status"]; // 設定新的漫畫書狀態
        $sql = "UPDATE comics_collection SET comics_status = :new_status WHERE comics_id = :comics_id";
        $comics = $pdo->prepare($sql);

        $comics->bindValue(":new_status", $newStatus);
        $comics->bindValue(":comics_id", $comics_id);
        $comics->execute();

        echo 'success';
    } else {
        echo 'Invalid data';
    }
} catch (Exception $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>
