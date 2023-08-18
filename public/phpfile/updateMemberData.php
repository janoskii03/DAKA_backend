<?php 
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With');

try {
$postData = json_decode(file_get_contents('php://input'), true);
require_once("connectDaka.php");
 //執行sql指令
  // $mem_id = $postData["mem_id"];
  $sql = "UPDATE member SET mname = :mname,
  sex = :sex,
  mobile = :mobile,
  password = :password,
  address = :address,
  member_birth = :member_birth,
  email = :email
  WHERE mem_id = :mem_id";
        
        
$member = $pdo-> prepare($sql);
$member->bindValue(":mem_id", $postData["mem_id"]);
$member->bindValue(":mname", $postData["mname"]);
$member->bindValue(":sex", $postData["sex"]);
$member->bindValue(":mobile", $postData["mobile"]);
$member->bindValue(":password", $postData["password"]);
$member->bindValue(":member_birth", $postData["member_birth"]);
$member->bindValue(":address", $postData["address"]);
$member->bindValue(":email", $postData["email"]);
$member->execute();
echo 'success';


} catch (PDOException $e) {
echo "錯誤行號 : ", $e->getLine(), "<br>";
echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
?>