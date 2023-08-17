<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    if($_FILES["img"]["error"] === 0 && $_FILES["comics_readfirst"]["error"] === 0) {
        $dir = "../comic/";

        $from = $_FILES["img"]["tmp_name"];
        $fromReadFirst = $_FILES["comics_readfirst"]["tmp_name"];

        //決定檔案名稱:原先的$_FILES["image"]["name"]副檔名可能是png,gif
        //---產生主檔名
        $fileName = uniqid();
        $readFirstFileName = uniqid();

        //---取出副檔名
        $fileExt = pathInfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
        $readFirstFileExt = pathInfo($_FILES["comics_readfirst"]["name"], PATHINFO_EXTENSION);
        
        $fileName = "$fileName.$fileExt";
        $readFirstFileName = "$readFirstFileName.$readFirstFileExt";
        
        $to = $dir . $fileName;
        $toReadFirst = $dir . $readFirstFileName;

        if(copy($from, $to) && copy($fromReadFirst, $toReadFirst)){
            //寫入資料庫
            try {
                require_once("connectDaka.php");
                
                $sql = "INSERT INTO comics_collection (title, comics_index, type, isbn, author, translator, intro, publisher, publication_date, language, comics_price, comics_status, img, comics_readfirst) 
                        VALUES (:title, :comics_index, :type, :isbn, :author, :translator, :intro, :publisher, :publication_date, :language, :comics_price, 1, :img, :comics_readfirst)";
                $products = $pdo->prepare($sql); 
                $products->bindValue(":img", $fileName);
                $products->bindValue(":comics_readfirst", $readFirstFileName);
                // ...（其余的bindValue部分保持不变）

                $products->execute();

                $comics_id = $pdo->lastInsertId();
                $comics_no = "CM" . str_pad($comics_id, 4, "0", STR_PAD_LEFT );
                $sql = "update comics_collection set comics_no = '$comics_no' where comics_id = $comics_id";
                $pdo->exec($sql);
                echo "新增成功";
            } catch (PDOException $e) {
                echo "錯誤行號 : ", $e->getLine(), "<br>";
                echo "錯誤原因 : ", $e->getMessage(), "<br>"; 

                $message = "錯誤行號 : ". $e->getLine(). "錯誤原因 : ". $e->getMessage();
                $msg = ["error" => true, "message" => $message]; 
            }

        } else {
            $msg = ["error" => true, "message" => "寫入失敗"]; 
            echo json_encode($msg);
        }

    } else {
        $msg = ["error" => true, "message" => "未上傳圖檔"]; 
        echo json_encode($msg);
    }

} catch (PDOException $e) {
    echo "錯誤行號 : ", $e->getLine(), "<br>";
    echo "錯誤原因 : ", $e->getMessage(), "<br>";
}
?>
