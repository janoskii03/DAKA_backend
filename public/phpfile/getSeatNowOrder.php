<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
try {
    // 引入連線工作的檔案
    require_once("connectDaka.php");

    // 執行sql指令並取得pdoStatement
    $sql = "SELECT so.seat_order_id, so.seat_order_startdate, so.seat_order_enddate, sod.seat_id, s.seat_area, s.seat_number, m.mname, m.mobile
    FROM seat_order so
    JOIN seat_order_detail sod ON so.seat_order_id = sod.seat_order_id
    JOIN seat s on sod.seat_id = s.seat_id
    join member m on so.mem_id = m.mem_id
    WHERE DATE(so.seat_order_startdate) = CURDATE()
    ORDER BY so.seat_order_id"; // 根據 seat_order_id 排序结果

    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    // 對查詢結果進行分組處理
    $orders = array();

    foreach ($prodRows as $row) {
        $seat_order_id = $row['seat_order_id'];
        if (!isset($orders[$seat_order_id])) {
            // array_push($orders, $row);
            $orders[$seat_order_id] = array(
                'seat_order_id' => $seat_order_id,
                'seat_area' => $row['seat_area'],
                'seat_order_startdate' => $row['seat_order_startdate'],
                'seat_order_enddate' => $row['seat_order_enddate'],
                'seat_id' => $row['seat_id'],
                'seat_area' => $row['seat_area'],
                'seat_number' => $row['seat_number'],
                'mname' => $row['mname'],
                'mobile' => $row['mobile'],
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