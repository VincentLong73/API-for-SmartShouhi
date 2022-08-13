<?php 

    include_once '../config/connect_db.php';
    include_once '../model/user.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        // Bat dau xu ly form. Tao bien $errors
        $errors = array();

        
        // Validate email
        if(isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $e = mysqli_real_escape_string($connect, $_GET['email']); 
        } else {
            $errors[] = 'email';
        }
        
        
        if(empty($errors)) {
            // Bat dau truy van CSDL de lay thong tin nguoi dung
            $query = "SELECT id, user_name, full_name, phone, date_of_birth FROM user WHERE email = '{$e}'";
            
            // echo $query;
            mysqli_query($connect, "SET NAMES 'utf8'");
  
            $result_query = mysqli_query($connect, $query); 
            //confirm_query($r, $q);
            
            if(mysqli_num_rows($result_query) == 1) {
                session_regenerate_id();
                // Neu tim thay thong tin nguoi dung trong CSDL, se chuyen huong nguoi dung ve trang thich hop.
                list($uid, $user_name, $full_name, $phone, $dob) = mysqli_fetch_array($result_query, MYSQLI_NUM);
                $is_active = TRUE;

                $user = new User($uid, $e, $user_name, $full_name, $phone, is_admin($connect, $uid), $is_active, $dob);
                $message = "";
                $result_code = "";
                $message = json_encode($user);
                $result_code = 200;
            } else {
                $message = "";
                $result_code = "";
                $message = "Email không đúng";
                $result_code = 501;
            }
        } else {
            $message = "";
            $result_code = "";
            $message = "Vui lòng nhập đầy đủ các trường thông tin";
            $result_code = 501;
        }
    
    }

    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);

    

    function is_admin($connect, $user_id) {        

        $query = "SELECT role_name FROM `role` INNER join user where role.id = user.role_id and user.id = '{$user_id}' ";
            
        mysqli_query($connect, "SET NAMES 'utf8'");
  
        $result =mysqli_fetch_row(mysqli_query($connect, $query)) ; 

        //return $result[0];
        if($result && $result[0] == 'Admin'){
            return true;
        }
        return false;
    }

    //$db->close();
?>
