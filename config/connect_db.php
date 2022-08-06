<?php

//$connect_db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
class ConnectDatabase {
 private $conn;

 function __construct() {
   // Ket noi database
   $this->connect();
 }
 function __destruct() {
  
  $this->close();
 }
 /**
 * Ket noi den database
 *
 */
 function connect() {
   include_once 'config.php';
  // ket noi den mysql
  $this->conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_error($this->conn));

   mysqli_query($this->conn, "SET NAMES 'utf8'");
  return $this->conn;
 }
 /**
 * Đóng kết nối
 */
 function close() {
   // Đóng kết nối CSDL
   mysqli_close($this->conn);
 }
}
?>
