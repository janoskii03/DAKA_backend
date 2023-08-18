<?php 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With');

try {
$postData = json_decode(file_get_contents('php://input'), true);
require_once("connectDaka.php");
 //執行sql指令
  // $mem_id = $postData["mem_id"];
  $sql = "UPDATE administrator SET ename = :ename,
  branch = :branch,
  admin_no = :admin_no,
  ejob = :ejob,
  password = :password
  WHERE admin_id = :admin_id";
        
        
$member = $pdo-> prepare($sql);
$member->bindValue(":admin_id", $postData["admin_id"]);
$member->bindValue(":ename", $postData["ename"]);
$member->bindValue(":branch", $postData["branch"]);
$member->bindValue(":admin_no", $postData["admin_no"]);
$member->bindValue(":ejob", $postData["ejob"]);
$member->bindValue(":password", $postData["password"]);
$member->execute();
echo 'success';


} catch (PDOException $e) {
echo "錯誤行號 : ", $e->getLine(), "<br>";
echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
?>