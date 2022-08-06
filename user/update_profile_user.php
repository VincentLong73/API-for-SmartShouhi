<?php 

    include_once '../config/connect_db.php';
    include_once '../model/user.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email = $_POST['email'];
        $user_name = $_POST['userName'];
        $full_name = $_POST['fullName'];
        $phone = $_POST['phone'];
        $date_of_birth = $_POST['dob'];

        $query_email = "SELECT id FROM user WHERE email = '{$email}' ";
        $result_email = mysqli_query($connect, $query_email); 

        if(mysqli_num_rows($result_email) == 1){
            $query = "UPDATE user SET user_name = '{$user_name}', full_name = '{$full_name}', phone = '{$phone}', date_of_birth = '{$date_of_birth}' WHERE email = '{$email}' ";  
            mysqli_query($connect, "SET NAMES 'utf8'");

            $result_query = mysqli_query($connect, $query); 
            
            if($result_query) {
                // $message = "Updated Successfully";
                // $result = 200;
                $message = "";
                $result_code = "";
                $result_code = 200;
                $message = "Updated Successfully";
                
            } else {
                // $message = "Updated Failed";
                // $result = 201;
                $message = "";
                $result_code = "";
                $result_code = 501;
                $message = "Updated Failed";
            }
        }else{
            // Email not exist
            // $result = 203;
            $message = "";
            $result_code = "";
            $result_code = 501;
            $message = "Email not exist";
        }

    } else {
        // $message = "Please fill in all the required fields";
        // $result = 202;
        $message = "";
        $result_code = "";
        $result_code = 501;
        $message = "Please fill in all the required fields";
    }

    $result = "";
    header('Content-Type: application/json');
    $result = $result_code."#".json_encode($message);

    header('Content-Type: application/json');
    echo json_encode($result);
    
?>
