<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
  // $postData = json_decode(file_get_contents('php://input'), true);
	if($_FILES["image"]["error"] === 0) {
    $dir = "../images/";

    $from = $_FILES["image"]["tmp_name"];
    
    //決定檔案名稱:原先的$_FILES["image"]["name"]副檔名可能是png,gif
    //---產生主檔名
    $fileName = uniqid();

    //---取出副檔名
    $fileExt = pathInfo($_FILES["image"]["name"], PATHINFO_EXTENSION); //ann.gif
    //PATHINFO_DIRNAME、 PATHINFO_BASENAME、 PATHINFO_EXTENSION、 PATHINFO_FILENAME。
    
    $fileName = "$fileName.$fileExt";//用uniqid()去串接副檔名

    $to = $dir . $fileName;
    if(copy($from, $to)){
        //寫入資料庫
        try {
            require_once("connectDaka.php");
            $sql = "update member set pic = :pic
            where mem_id = :mem_id";
            $products = $pdo->prepare($sql); 
            $products->bindValue(":mem_id", $_POST["mem_id"]);
            $products->bindValue(":pic", $fileName);
            $products->execute();
            // $msg = ["error" => false, "message" => "新增商品成功", "psn" => $pdo->lastInsertId(), "image" => $fileName];
            echo "新增成功";
        } catch (PDOException $e) {
            echo "錯誤行號 : ", $e->getLine(), "<br>";
            echo "錯誤原因 : ", $e->getMessage(), "<br>"; 
            //"錯誤行號 : ". $e->getLine(). "錯誤原因 : ". $e->getMessage()

            //echo "系統暫時不能正常運行，請稍後再試<br>"; 
            $message = "錯誤行號 : ". $e->getLine(). "錯誤原因 : ". $e->getMessage();
            $msg = ["error" => true, "message" => $message]; 
        }

    }else{
        $msg = ["error" => true, "message" => "寫入失敗"]; 
        echo json_encode($msg);
    }

} else {
    $msg = ["error" => true, "message" => "未上傳圖檔"]; 
}

} catch (PDOException $e) {
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";

}
// echo json_encode($msg);
?>
