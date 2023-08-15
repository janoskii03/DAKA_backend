<?php 
	header('Access-Control-Allow-Origin:*');
	header("Content-Type:application/json;charset=utf-8");
try {
	//引入連線工作的檔案
	require_once("connectDaka.php");
	
	//執行sql指令並取得pdoStatement
	$sql = "select n.news_title, n.news_date, n.news_category, n.news_status, n.news_text, a.admin_id, a.ename
	from news n
	join administrator a on n.admin_id = a.admin_id
	order by n.news_id";

	$products = $pdo->query($sql); 
	$prodRows = $products->fetchAll(PDO::FETCH_ASSOC);

	echo json_encode($prodRows);

} catch (Exception $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";
	//echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>
