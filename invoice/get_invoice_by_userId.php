<?php
  include_once '../config/connect_db.php';
  include_once '../model/invoice.php';

  $db = new ConnectDatabase();
  $connect = $db->connect();
  $result_code = 404;
  $message = "Not Found";
 
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    mysqli_query($connect, "SET NAMES 'utf8'");
   // Mang Json
    $response = array();

    $username_enter = $_GET['id'];

    $query_all = "SELECT * FROM invoice where user_id = ";
    $query = $query_all.$username_enter;
    $result_sql = mysqli_query($connect, $query);

    while($row = mysqli_fetch_assoc($result_sql)){
      // Mảng JSON
      array_push($response, new Invoice($row["id"], $row["address"], $row["seller"], $row["time_stamp"], $row["total_cost"]));
   }
    $message = "";
    $result_code = "";
    $message = $response;
    $result_code = 200;
  }

  $result = "";
  // header('Content-Type: application/json');
  $result = $result_code."#".json_encode($message);

  // header('Content-Type: application/json');
  echo json_encode($result);

?>
