<?php 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With');

try {
    $postData = json_decode(file_get_contents('php://input'), true);
	require_once("connectDaka.php");
	//執行sql指令
	$sql = "INSERT INTO member (mname, sex, mobile, password, member_birth, email, address)
            VALUES (:mname, :sex, :mobile, :password, :member_birth, :email, :address)";
	$member = $pdo-> prepare($sql);
    $member->bindValue(":mname", $postData["mname"]);
	$member->bindValue(":sex", $postData["sex"]);
	$member->bindValue(":mobile", $postData["mobile"]);
	$member->bindValue(":password", $postData["password"]);
    $member->bindValue(":member_birth", $postData["member_birth"]);
    $member->bindValue(":address", $postData["address"]);
    $member->bindValue(":email", $postData["email"]);
	$member->execute();

    $mem_id = $pdo->lastInsertId();
    $mem_no = "MB" . str_pad($mem_id, 4, "0", STR_PAD_LEFT);
    $sql = "update member set mem_no = '$mem_no' where mem_id = $mem_id";
    $pdo->exec($sql);

	echo 'success';


} catch (PDOException $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
?>
