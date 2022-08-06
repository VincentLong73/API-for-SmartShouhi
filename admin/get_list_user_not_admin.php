<?php

 include_once '../model/user.php';
 include_once '../config/connect_db.php';
   
 $result_code = 404;
 $message = "Not Found";

 $db = new ConnectDatabase();
 $connect = $db->connect();
 if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mang Json
    $response = array();
    mysqli_query($connect, "SET NAMES 'utf8'");
    $query = "SELECT * FROM user WHERE role_id = 2";
    $result_sql = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result_sql)){
      // Mảng JSON                  $id, $email, $userName, $fullName, $phone, $isAdmin, $isActive, $dob
      array_push($response, new User($row["id"], $row["email"], $row["user_name"], $row["full_name"], $row["phone"], is_admin($connect, $row["id"]), is_active($row["active"]), $row["date_of_birth"]));
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
  // header('Content-Type: application/json');
  // echo json_encode($response);



 function is_admin($connect, $user_id) {        

  $query = "SELECT role_name FROM `role` INNER join user where role.id = user.role_id and user.id = '{$user_id}' ";
      
  mysqli_query($connect, "SET NAMES 'utf8'");

  $result_is_admin =mysqli_fetch_row(mysqli_query($connect, $query)) ; 

  //return $result[0];
  if($result_is_admin && $result_is_admin[0] == 'Admin'){
      return true;
  }
  return false;
}

function is_active($status){
  if($status == 1){
    return true;
  }
  return false;
}

?>
