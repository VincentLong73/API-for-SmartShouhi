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
                $message = "Delete Item Successfully";
                $result_code = 200;
            
            } else {
                $message = "";
                $result_code = "";
                $message = "Delete Item Failed";
                $result_code = 501;
            }
        } else {
            $message = "";
            $result_code = "";
            $message = "Invoice Not Exist";
            $result_code = 501;
        }
    }

    $result = "";
    $result = $result_code."#".$message;

    header('Content-Type: application/json');
    echo json_encode($result);
    
?>
