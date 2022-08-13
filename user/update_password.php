<?php 

    include_once '../config/connect_db.php';
    include_once '../model/user.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email = $_POST['email'];
        $pass_word_old = $_POST['pass_word_old'];
        $pass_word_new = $_POST['pass_word_new'];


        mysqli_query($connect, "SET NAMES 'utf8'");

        $query_email = "SELECT id, pass_word FROM user WHERE email = '{$email}' ";
        // echo $query_email;
          
        $result_email = mysqli_query($connect, $query_email); 
        if(mysqli_num_rows($result_email) == 1){

            $query_password = "SELECT id, pass_word FROM user WHERE email = '{$email}' AND pass_word = SHA1('$pass_word_old')"; 
            $result_password = mysqli_query($connect, $query_password); 
            
            if(mysqli_num_rows($result_password) == 1){
                $query_update_pass = "UPDATE user SET pass_word = SHA1('$pass_word_new') WHERE email = '{$email}'";
                $result_update = mysqli_query($connect, $query_update_pass); 
                if($result_update) {

                    $message = "";
                    $result_code = "";
                    $result_code = 200;
                    $message = "Cập nhật thành công";
                    
                } else {

                    $message = "";
                    $result_code = "";
                    $result_code = 501;
                    $message = "Cập nhật không thành công";
                    
                }
            }else{

                $message = "";
                $result_code = "";
                $message = "Nhap sai pass cu";
                $result_code = 501;
            }
            

        }else{
            $message = "";
            $result_code = "";
            $message = "Email không tồn tại";
            $result_code = 501;
        }


        $result = "";
        $result = $result_code."#".$message;
        header("Content-type: text/html","charset=utf-8");
        echo html_entity_decode($result);


    }
    
?>
