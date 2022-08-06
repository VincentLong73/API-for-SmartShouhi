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

    $user_id = $_GET['id'];
    $year_selected = $_GET['year'];
    $time_start = $year_selected.'-01-01';
    $time_end = $year_selected.'-12-31';

    $query = "SELECT * FROM invoice WHERE user_id = '{$user_id}' AND time_stamp >= '{$time_start}' AND time_stamp <= '{$time_end}'";
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
  header('Content-Type: application/json');
  $result = $result_code."#".json_encode($message, true);

  header('Content-Type: application/json');
  echo json_encode($result);

?>
