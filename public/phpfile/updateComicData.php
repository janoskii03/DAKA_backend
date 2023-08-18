<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("connectDaka.php");
    
    $sql = "update comics_collection set title = :title,
    comics_index = :comics_index,
    type = :type,
    isbn = :isbn,
    author = :author,
    translator = :translator,
    intro = :intro,
    publisher = :publisher,
    publication_date = :publication_date,
    language = :language,
    comics_price = :comics_price,
    comics_status = :comics_status,
    img = :img,
    comics_readfirst = :comics_readfirst,
    comics_no = :comics_no,
            where comics_id = :comics_id";
    
    $products = $pdo->prepare($sql); 
    $products->bindValue(":comics_id", $_POST["comics_id"]);
    $products->bindValue(":comics_no", $_POST["comics_no"]);
    $products->bindValue(":comics_readfirst", $_POST["comics_readfirst"]);
    $products = $pdo->prepare($sql); 
    $products->bindValue(":img", $_POST["img"]);
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
    $products->bindValue(":title", $_POST["title"]);

    $updateResult = $products->execute();
    
    if ($updateResult) {
        if($_FILES["img"]["error"] === 0 && $_FILES["comics_readfirst"]["error"] === 0) {
            $dir = "../comic/";

    $from = $_FILES["img"]["tmp_name"];
    $fromReadFirst = $_FILES["comics_readfirst"]["tmp_name"];
            
    $fileName = uniqid();
    $readFirstFileName = uniqid("RD");
    $fileExt = pathInfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
    $readFirstFileExt = pathInfo($_FILES["comics_readfirst"]["name"], PATHINFO_EXTENSION);
            $fileName = "$fileName.$fileExt";
            $readFirstFileName = "$readFirstFileName.$readFirstFileExt";

    $to = $dir . $fileName;
    $toReadFirst = $dir . $readFirstFileName;
            
    if(copy($from, $to) && copy($fromReadFirst, $toReadFirst)){
                $updateImageSQL = "update comics_collection set img = :img where comics_id = :comics_id";
                $updateImageStmt = $pdo->prepare($updateImageSQL);
                $updateImageStmt->bindValue(":comics_id", $_POST["comics_id"]);
                $updateImageStmt->bindValue(":img", $fileName);
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
