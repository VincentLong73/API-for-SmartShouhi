<?php 

    include_once '../config/connect_db.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    mysqli_query($connect, "SET NAMES 'utf8'");
    $result_code = 404;
    $message = "Not Found";


    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $itemId = $_POST['itemId'];

        $query_select = "SELECT id FROM item WHERE id = '{$itemId}'";
        $result_select_item = mysqli_query($connect, $query_select);
        
        if(mysqli_num_rows($result_select_item) == 1) {

            $query_delete_item = "DELETE FROM item WHERE id = '{$itemId}' ";  
            $result_delete_item = mysqli_query($connect, $query_delete_item);

            if($result_delete_item) {
                $message = "";
                $result_code = "";
                $message = "Xóa sản phẩm thành công";
                $result_code = 200;
            
            } else {
                $message = "";
                $result_code = "";
                $message = "Xóa sản phẩm không thành công";
                $result_code = 501;
            }
        } else {
            $message = "";
            $result_code = "";
            $message = "Sản phẩm không tồn tại";
            $result_code = 501;
        }
    }

    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);
    
?>
