<?php 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With');

try {
    $postData = json_decode(file_get_contents('php://input'), true);
	require_once("connectDaka.php");
	//執行sql指令
	$sql = "INSERT INTO administrator (ename, branch, admin_no, ejob, password)
            VALUES (:ename, :branch, :admin_no, :ejob, :password)";
	$administrator = $pdo-> prepare($sql);
    $administrator->bindValue(":ename", $postData["ename"]);
	$administrator->bindValue(":branch", $postData["branch"]);
	$administrator->bindValue(":admin_no", $postData["admin_no"]);
	$administrator->bindValue(":ejob", $postData["ejob"]);
    $administrator->bindValue(":password", $postData["password"]);
	$administrator->execute();

    $admin_id = $pdo->lastInsertId();
    $admin_no = "MB" . str_pad($admin_id, 4, "0", STR_PAD_LEFT);
    $sql = "update administrator set admin_no = '$admin_no' where admin_id = $admin_id";
    $pdo->exec($sql);

	echo 'success';


} catch (PDOException $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
?>
