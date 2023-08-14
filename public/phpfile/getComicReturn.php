<?php 
	header('Access-Control-Allow-Origin:*');
	header("Content-Type:application/json;charset=utf-8");
try {
    // 引入連線工作的檔案
    require_once("connectDaka.php");

    // 執行sql指令並取得pdoStatement
    $sql = "select m.mname, m.mobile, c.comics_order_no, c.comics_order_status, c.comics_order_date, c.comics_borrow_date, c.comics_return_duedate, co.comics_order_detail_id, co.comics_order_id, co.comics_id, cc.comics_no, cc.title, cc.comics_index
            FROM member m 
            JOIN comics_order c ON m.mem_id = c.mem_id
            JOIN comics_order_detail co ON c.comics_order_id = co.comics_order_id
            JOIN comics_collection cc ON co.comics_id = cc.comics_id
            WHERE c.comics_order_status = 3
            ORDER BY co.comics_order_id"; // 根據 comics_order_id 排序结果

    $products = $pdo->query($sql); 
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    // 定義狀態對應陣列
    $statusMapping = array(
        0 => '預約過期',
        1 => '未取書',
        2 => '已取消',
        3 => '已取書',
        4 => '已歸還',
        5 => '有罰金'
    );
    // 對查詢結果進行分組處理
    $orders = array();

    foreach ($prodRows as $row) {
        $order_id = $row['comics_order_id'];
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = array(
                'order_id' => $order_id,
                'mname' => $row['mname'],
                'mobile' => $row['mobile'],
                'comics_order_no' => $row['comics_order_no'],
                'comics_return_duedate' => $row['comics_return_duedate'],
                'comics_order_date' => $row['comics_order_date'],
                'comics_borrow_date' => $row['comics_borrow_date'],
                'comics_order_status' => $statusMapping[$row['comics_order_status']],
                'items' => array()
            );
        }

        $orders[$order_id]['items'][] = array(
            'comics_order_detail_id' => $row['comics_order_detail_id'],
            'comics_id' => $row['comics_id'],
            'comics_no' => $row['comics_no'],
            'title' => $row['title'],
            'comics_index' => $row['comics_index']
        );
    }

    echo json_encode(array_values($orders)); // 轉換為索引數組並輸出

} catch (Exception $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
    //echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>

