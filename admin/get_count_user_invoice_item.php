<?php

 include_once '../model/user.php';
 include_once '../config/connect_db.php';
   // Mang Json
   $response = array();
   $result_code = 404;
   $message = "Not Found";
   
   $db = new ConnectDatabase();
   $connect = $db->connect();
   mysqli_query($connect, "SET NAMES 'utf8'");
   if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $query_count_user = "SELECT COUNT(*) as item_user FROM user WHERE role_id = 2";
    $result_count_user = mysqli_query($connect, $query_count_user);
    $count_user = mysqli_fetch_assoc($result_count_user)["item_user"];
   
    $query_count_invoice = "SELECT COUNT(*) as item_invoice FROM invoice";
    $result_count_invoice = mysqli_query($connect, $query_count_invoice);
    $count_invoice = mysqli_fetch_assoc($result_count_invoice)["item_invoice"];
   
    $query_count_item = "SELECT COUNT(*) as item_number FROM item";
    $result_count_item = mysqli_query($connect, $query_count_item);
    $count_item = mysqli_fetch_assoc($result_count_item)["item_number"];
    
    $message = "";
    $result_code = "";
    $message = $count_user."#".$count_invoice."#".$count_item;
    $result_code = 200;
   }

   $result = "";
   $result = $result_code."#".$message;

   header('Content-Type: application/json');
   echo json_encode($result);

?>
