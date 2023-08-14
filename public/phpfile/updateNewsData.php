<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("connectDaka.php");
    
    $sql = "update news set news_title = :news_title,
                            news_date = :news_date,
                            news_category = :news_category,
                            news_text = :news_text
            where news_id = :news_id";
    
    $products = $pdo->prepare($sql); 
    $products->bindValue(":news_id", $_POST["news_id"]);
    $products->bindValue(":news_title", $_POST["news_title"]);
    $products->bindValue(":news_date", $_POST["news_date"]);
    $products->bindValue(":news_category", $_POST["news_category"]);
    $products->bindValue(":news_text", $_POST["news_text"]);
    
    $updateResult = $products->execute();
    
    if ($updateResult) {
        if($_FILES["news_pic"]["error"] === 0) {
            $dir = "../news/";
            $from = $_FILES["news_pic"]["tmp_name"];
            
            $fileName = uniqid();
            $fileExt = pathInfo($_FILES["news_pic"]["name"], PATHINFO_EXTENSION);
            $fileName = "$fileName.$fileExt";
            $to = $dir . $fileName;
            
            if(copy($from, $to)){
                $updateImageSQL = "update news set news_pic = :news_pic where news_id = :news_id";
                $updateImageStmt = $pdo->prepare($updateImageSQL);
                $updateImageStmt->bindValue(":news_id", $_POST["news_id"]);
                $updateImageStmt->bindValue(":news_pic", $fileName);
                $updateImageStmt->execute();
                
                echo "更新成功（含圖片）";
            } else {
                echo "更新成功（無法上傳圖片）";
            }
        } else {
            echo "更新成功（不含圖片）";
        }
    } else {
        echo "更新失败";
    }
} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>"; 

    $message = "錯誤行號 : ". $e->getLine(). "錯誤原因 : ". $e->getMessage();
    $msg = ["error" => true, "message" => $message]; 
}
?>
