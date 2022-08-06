<?php 

    include_once '../config/connect_db.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $itemId = $_POST['itemId'];
        $itemName = $_POST['itemName'];
        $itemCost = $_POST['itemCost'];

        mysqli_query($connect, "SET NAMES 'utf8'");

        $query_update_item = "UPDATE item SET item_name = '{$itemName}', item_cost = '{$itemCost}' WHERE id = '{$itemId}' ";  
        mysqli_query($connect, "SET NAMES 'utf8'");

        $result_update_item = mysqli_query($connect, $query_update_item); 
        
        if($result_update_item) {
            $message = "";
            $result_code = "";
            $message = "Updated Item Successfully";
            $result_code = 200;
        }else{
            $message = "";
            $result_code = "";
            $message = "Updated Item Failed";
            $result_code = 501;
        }


    } else {
        // $message = "Please fill in all the required fields";
        $message = "";
        $result_code = "";
        $message = "Please fill in all the required fields";
        $result_code = 501;
    }

    $result = "";
    $result = $result_code."#".$message;

    header('Content-Type: application/json');
    echo json_encode($result);
    
?>
