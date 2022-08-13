<?php 

    include_once '../config/connect_db.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();

    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {


        $email = $_POST['email'];
        $email_admin = $_POST['email_admin'];
        $date_modified = $_POST['date_modified'];

        mysqli_query($connect, "SET NAMES 'utf8'");

        $query_email = "SELECT id FROM user WHERE email = '{$email}' ";   
        $result_email = mysqli_query($connect, $query_email); 

        if(mysqli_num_rows($result_email) == 1){

            $query_block_user = "UPDATE user SET active = FALSE, date_modified = '{$date_modified}', user_modified = '{$email_admin}' WHERE email = '{$email}'";

            $result_block = mysqli_query($connect, $query_block_user); 
            if($result_block) {
                $message = "";
                $result_code = "";
                $message = "Chặn thành công";
                $result_code = 200;
            } else {
                $message = "";
                $result_code = "";
                $message = "Chặn không thành công";
                $result_code = 501;
            }

        }else{
            $message = "";
            $result_code = "";
            $message = "Email không tồn tại";
            $result_code = 501;
        }

    }
    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);
    
?>
