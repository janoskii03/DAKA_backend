<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
try {
    // 引入連線工作的檔案
    require_once("connectDaka.php");

    // 執行sql指令並取得pdoStatement
    $sql = "select so.seat_order_id, so.seat_order_state, m.mem_id, m.mname, m.mobile, s.seat_id, s.seat_area, s.seat_number, so.seat_order_startdate, so.seat_order_enddate, so.seat_order_time, so.seat_order_sum , sod.seat_order_detail_id
            FROM member m
            JOIN seat_order so ON m.mem_id =so.mem_id
            JOIN seat_order_detail sod ON so.seat_order_id = sod.seat_order_id
            JOIN seat s ON sod.seat_id = s.seat_id
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
                'mname' => $row['mname'],
                'mobile' => $row['mobile'],
                'seat_order_startdate' => $row['seat_order_startdate'],
                'seat_order_enddate' => $row['seat_order_enddate'],
                'seat_order_time' => $row['seat_order_time'],
                'seat_order_sum' => $row['seat_order_sum'],
                'seat_order_state' => $row['seat_order_state'],
                'items' => array()
            );
        }

        $orders[$seat_order_id]['items'][] = array(
            'seat_order_detail_id' => $row['seat_order_detail_id'],
            'seat_id' => $row['seat_id'],
            'seat_area' => $row['seat_area'],
            'seat_number' => $row['seat_number'],
        );
    }

    echo json_encode(array_values($orders)); // 轉換為索引數組並輸出

} catch (Exception $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
    //echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>