<?php 
	header('Access-Control-Allow-Origin:*');
	header("Content-Type:application/json;charset=utf-8");
try {
    // 引入連線工作的檔案
    require_once("connectDaka.php");

    // 執行sql指令並取得pdoStatement
    $sql = "select m.mname, m.mobile, c.comics_order_no, c.comics_order_status, c.comics_order_date, co.comics_order_detail_id, co.comics_order_id, co.comics_id, cc.comics_no, cc.title, cc.comics_index
            FROM member m 
            JOIN comics_order c ON m.mem_id = c.mem_id
            JOIN comics_order_detail co ON c.comics_order_id = co.comics_order_id
            JOIN comics_collection cc ON co.comics_id = cc.comics_id
            ORDER BY co.comics_order_id"; // 根据 comics_order_id 排序结果

    $products = $pdo->query($sql); 
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);

    // 对查询结果进行分组处理
    $orders = array();

    foreach ($prodRows as $row) {
        $order_id = $row['comics_order_id'];
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = array(
                'order_id' => $order_id,
                'mname' => $row['mname'],
                'mobile' => $row['mobile'],
                'comics_order_no' => $row['comics_order_no'],
                'comics_order_date' => $row['comics_order_date'],
                'comics_order_status' => $row['comics_order_status'],
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

    echo json_encode(array_values($orders)); // 转换为索引数组并输出

} catch (Exception $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
    //echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>

