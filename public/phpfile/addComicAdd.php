<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
  // $postData = json_decode(file_get_contents('php://input'), true);
	if($_FILES["img"]["error"] === 0) {
    $dir = "../comic/";

    $from = $_FILES["img"]["tmp_name"];
    
    //決定檔案名稱:原先的$_FILES["image"]["name"]副檔名可能是png,gif
    //---產生主檔名
    $fileName = uniqid();

    //---取出副檔名
    $fileExt = pathInfo($_FILES["img"]["name"], PATHINFO_EXTENSION); //ann.gif
    //PATHINFO_DIRNAME、 PATHINFO_BASENAME、 PATHINFO_EXTENSION、 PATHINFO_FILENAME。
    
    $fileName = "$fileName.$fileExt";//用uniqid()去串接副檔名
    
    $to = $dir . $fileName;
    if(copy($from, $to)){
        //寫入資料庫
        try {
            require_once("connectDaka.php");
            
            // 尚未連動管理員登入，先暫且固定管理員編號
            // $admin_id = 2;

            $sql = "INSERT INTO comics_collection (title, comics_index, type, isbn, author, translator, intro, publisher, publication_date, language, comics_price, comics_status, img) 
                    VALUES (:title, :comics_index, :type, :isbn, :author, :translator, :intro, :publisher, :publication_date, :language, :comics_price, :comics_status, :img)";
            $products = $pdo->prepare($sql); 
            // $products->bindValue(":comics_id", $_POST["comics_id"]);
            $products->bindValue(":img", $fileName);
            // $products->bindValue(":comics_readfirst", $_POST["comics_readfirst"]);
            $products->bindValue(":comics_status", $_POST["comics_status"]);
            $products->bindValue(":comics_price", $_POST["comics_price"]);
            $products->bindValue(":language", $_POST["language"]);
            $products->bindValue(":publication_date", $_POST["publication_date"]);
            $products->bindValue(":publisher", $_POST["publisher"]);
            $products->bindValue(":intro", $_POST["intro"]);
            $products->bindValue(":translator", $_POST["translator"]);
            $products->bindValue(":author", $_POST["author"]);
            $products->bindValue(":isbn", $_POST["isbn"]);
            $products->bindValue(":type", $_POST["type"]);
            $products->bindValue(":comics_index", $_POST["comics_index"]);
            $products->bindValue(":intro", $_POST["intro"]);
            $products->bindValue(":title", $_POST["title"]);
            // $products->bindValue(":comics_no", $_POST["comics_no"]);
            $products->execute();

            $comics_id = $pdo->lastInsertId();
            $comics_no = "CM" . str_pad($comics_id, 4, "0", STR_PAD_LEFT );
            $sql = "update comics_collection set comics_no = '$comics_no' where comics_id = $comics_id";
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
