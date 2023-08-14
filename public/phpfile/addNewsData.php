<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
  // $postData = json_decode(file_get_contents('php://input'), true);
	if($_FILES["news_pic"]["error"] === 0) {
    $dir = "../news/";

    $from = $_FILES["news_pic"]["tmp_name"];
    
    //決定檔案名稱:原先的$_FILES["image"]["name"]副檔名可能是png,gif
    //---產生主檔名
    $fileName = uniqid();

    //---取出副檔名
    $fileExt = pathInfo($_FILES["news_pic"]["name"], PATHINFO_EXTENSION); //ann.gif
    //PATHINFO_DIRNAME、 PATHINFO_BASENAME、 PATHINFO_EXTENSION、 PATHINFO_FILENAME。
    
    $fileName = "$fileName.$fileExt";//用uniqid()去串接副檔名
    
    $to = $dir . $fileName;
    if(copy($from, $to)){
        //寫入資料庫
        try {
            require_once("connectDaka.php");
            
            $sql = "INSERT INTO news (news_pic, news_title, news_date, news_category, news_text) 
                    VALUES (:news_pic, :news_title, :news_date, :news_category, :news_text)";
            $products = $pdo->prepare($sql); 
            // $products->bindValue(":news_id", $_POST["news_id"]);
            $products->bindValue(":news_pic", $fileName);
            $products->bindValue(":news_title", $_POST["news_title"]);
            $products->bindValue(":news_date", $_POST["news_date"]);
            $products->bindValue(":news_category", $_POST["news_category"]);
            $products->bindValue(":news_text", $_POST["news_text"]);
            $products->execute();

            $news_id = $pdo->lastInsertId();
            $news_no = "N" . str_pad($news_id, 4, "0", STR_PAD_LEFT );
            $sql = "update news set news_no = '$news_no' where news_id = $news_id";
            $pdo->exec($sql);
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
