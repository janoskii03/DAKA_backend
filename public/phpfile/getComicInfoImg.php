<?php 
	header('Access-Control-Allow-Origin:*');
	header("Content-Type:application/json;charset=utf-8");
try {
	//引入連線工作的檔案
	require_once("connectDaka.php");
	
	//執行sql指令並取得pdoStatement
	$sql = "select n.comics_id, n.comics_no, n.title, n.comics_index, n.type, n.isbn, n.translator, n.intro, n.publisher, n.publication_date, n.language, n.comics_price, n.comics_status, n.img, n.comics_readfirst, n.comics_new, n.comics_hot, a.admin_id, a.ename
	from news n
	join administrator a on n.admin_id = a.admin_id
	order by n.comics_id";

	$sql = "select * from comics_collection";
	$products = $pdo->query($sql); 
	$prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($prodRows);

} catch (Exception $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";
	//echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>
