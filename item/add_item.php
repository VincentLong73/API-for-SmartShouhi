<?php 

    include_once '../config/connect_db.php';
    include_once '../model/invoice.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    mysqli_query($connect, "SET NAMES 'utf8'");
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $invoiceId = $_POST['invoiceId'];
        $listItem =  $_POST['listItem'];
        // print_r($listItem);

        $jsonListItem= array();
        $jsonListItem = json_decode($listItem, true);

        foreach ($jsonListItem as $item) {

            $itemName = $item["item_name"];
            $itemCost = $item["cost_item"];

            $query = "INSERT INTO item (item_name, item_cost, invoice_id) VALUES ('$itemName', '$itemCost', '$invoiceId')";
            $result_query = mysqli_query($connect, $query);
            

            if($result_query){
                $message = "";
                $result_code = "";
                $message = "Insert Item Successfully";
                $result_code = 200;
            }else{
                $message = "";
                $result_code = "";
                $message = "Insert Item Failed";
                $result_code = 501;
            }
        } 

    }
    $result = "";
    $result = $result_code."#".$message;

    header('Content-Type: application/json');
    echo json_encode($result);
?>
