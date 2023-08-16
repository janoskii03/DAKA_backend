<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
try {
    // 引入連線工作的檔案
    require_once("connectDaka.php");

    // 執行sql指令並取得pdoStatement
    $sql = "SELECT s.seat_id, ss.seat_state_date, ss.seat_status, s.seat_area, s.seat_number
    FROM seat_state ss
    JOIN seat s ON ss.seat_id = s.seat_id
    WHERE DATE(ss.seat_state_date) = CURDATE()
    ORDER BY s.seat_id
    "; // 根據 seat_order_id 排序结果

    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    // 對查詢結果進行分組處理
    $orders = array();

    foreach ($prodRows as $row) {
        $seat_id = $row['seat_id'];
        if (!isset($orders[$seat_id])) {
            $orders[$seat_id] = array(
                'seat_id' => $seat_id,
                'seat_state_date' => $row['seat_state_date'],
                'seat_status' => $row['seat_status'],
                'seat_area' => $row['seat_area'],
                'seat_number' => $row['seat_number'],
                'items' => array()
            );
        }
    }

    echo json_encode(array_values($orders)); // 轉換為索引數組並輸出

} catch (Exception $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
    //echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>