<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
session_start();

try {
  
  require_once("connectDaka.php");

  $post_data = file_get_contents("php://input"); // 获取 POST 数据
  $loginData = json_decode($post_data, true); // 将 JSON 数据解码为关联数组

  if (!isset($loginData["admin_no"]) || !isset($loginData["password"])) {
    echo "缺少必要的参数";
  } else {
    $sql = "select * from administrator where admin_no = :admin_no and password = :password";
    $member = $pdo->prepare($sql);
    $member->bindValue(":admin_no", $loginData["admin_no"]);
    $member->bindValue(":password", $loginData["password"]);
    $member->execute();

    if ($member->rowCount() == 0) { 
      echo "帳號密碼錯誤";
    } else { //登入成功
      //自資料庫中取回資料
      $memRow = $member->fetch(PDO::FETCH_ASSOC);

      //登入成功,將登入者的資料寫入session
      $_SESSION["admin_no"] = $memRow["admin_no"];
      $_SESSION["admin_id"] = $memRow["admin_id"];
      $_SESSION["ename"] = $memRow["ename"];
      $_SESSION["branch"] = $memRow["branch"];
      $_SESSION["ejob"] = $memRow["ejob"];
      $_SESSION["password"] = $memRow["password"];
     
     
      

      //送出登入者的資料
      $result = ["admin_no" => $_SESSION["admin_no"], "admin_id" => $_SESSION["admin_id"], "ename" => $_SESSION["ename"],"branch" => $_SESSION["branch"],"ejob" => $_SESSION["ejob"],"password" => $_SESSION["password"]];

      echo json_encode($result); //{"memNo":1, "memId": "Sara",...}  
    }
  }
} catch (Exception $e) {
  echo "錯誤行號 : ", $e->getLine(), "<br>";
  echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
