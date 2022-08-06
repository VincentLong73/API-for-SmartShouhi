<?php 

    include_once '../config/connect_db.php';
    include_once '../model/user.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Bat dau xu ly form. Tao bien $errors
        $errors = array();

        
        // Validate email
        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $e = mysqli_real_escape_string($connect, $_POST['email']); 
        } else {
            $errors[] = 'email';
        }
        
        // Validate password
        if(isset($_POST['password']) && preg_match('/^[\w]{4,20}$/', $_POST['password'])) {
            $p = mysqli_real_escape_string($connect, $_POST['password']);
        } else {
            $errors[] = 'password';
        }

        
        if(empty($errors)) {
            // Bat dau truy van CSDL de lay thong tin nguoi dung
            $query = "SELECT id, user_name, full_name, phone, date_of_birth FROM user WHERE email = '{$e}' AND pass_word = SHA1('$p') AND active = 1";
            
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
                // $message = "The email or password do not match those on file. Or you have not activated your account";
                // $user = new User('1',$result,'','','','','','');
                $message = "";
                $result_code = "";
                $message = "The email or password do not match those on file. Or you have not activated your account";
                $result_code = 501;
            }
        } else {
            // $message = "Please fill in all the required fields";
            // $result = 202;
            // $user = new User('1',$result,'','','','','','');
            $message = "";
            $result_code = "";
            $message = "Please fill in all the required fields";
            $result_code = 501;
        }
    
    }

    $result = "";
    $result = $result_code."#".$message;

    header('Content-Type: application/json');
    echo json_encode($result);

    

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
