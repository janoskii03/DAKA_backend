<?php 
	header("Access-Control-Allow-Origin: http://localhost:8080");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type");
	
try {
	//引入連線工作的檔案
	require_once("connectDaka.php");
	
	//執行sql指令並取得pdoStatement
	$sql = "select * from administrator";
	$products = $pdo->query($sql); 
	$prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($prodRows);

} catch (Exception $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";
	//echo "系統暫時不能正常運行，請稍後再試<br>";	
}
?>
