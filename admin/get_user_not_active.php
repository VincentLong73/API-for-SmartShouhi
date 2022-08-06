<?php
 //include_once 'connect_db.php';
 include_once '../model/user.php';
 include_once '../config/connect_db.php';
   

 $db = new ConnectDatabase();
 $connect = $db->connect();
 $result_code = 404;
 $message = "Not Found";

 if($_SERVER['REQUEST_METHOD'] == 'GET') {
  mysqli_query($connect, "SET NAMES 'utf8'");
  $query = "SELECT * FROM user WHERE role_id = 2 AND active is FALSE";
  $result_sql = mysqli_query($connect, $query);

  // Mang Json
  $response = array();
  
  while($row = mysqli_fetch_assoc($result_sql)){
    // Mảng JSON
    array_push($response, new User($row["id"], $row["email"], $row["user_name"], $row["full_name"], $row["phone"], $row["role_id"], $row["active"], $row["date_of_birth"]));
  }

  $message = "";
  $result_code = "";
  $message = $response;
  $result_code = 200;
 }

  $result = "";
  header('Content-Type: application/json');
  $result = $result_code."#".json_encode($message);

  header('Content-Type: application/json');
  echo json_encode($result);

?>
