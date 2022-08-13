<?php 

    include_once '../config/connect_db.php';
    include_once '../model/user.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";
    mysqli_query($connect, "SET NAMES 'utf8'");

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Bat dau xu ly form. Tao bien $errors
        $errors = array();

        // Validate email
        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = mysqli_real_escape_string($connect, $_POST['email']); 
        } else {
            $errors[] = 'email';
        }
        
        // Validate password
        if(isset($_POST['password']) && preg_match('/^[\w]{4,20}$/', $_POST['password'])) {
            $password = mysqli_real_escape_string($connect, $_POST['password']);
        } else {
            $errors[] = 'password';
        }

        if(isset($_POST['username']) && filter_var($_POST['username'], FILTER_DEFAULT)) {
            $username = mysqli_real_escape_string($connect, $_POST['username']); 
        } else {
            $errors[] = 'username';
        }

        if(isset($_POST['dob']) ) {
            $dob = mysqli_real_escape_string($connect, $_POST['dob']); 
        } else {
            $errors[] = 'dob';
        }

        if(isset($_POST['date_modified']) ) {
            $date_modified = mysqli_real_escape_string($connect, $_POST['date_modified']); 
        } else {
            $errors[] = 'date_modified';
        }

        
        if(empty($errors)) {
            
            $query_email = "SELECT id FROM user WHERE email = '{$email}' ";   
            $result_email = mysqli_query($connect, $query_email);


            if(mysqli_num_rows($result_email) != 1){
                $query = "INSERT INTO user (user_name, email, pass_word, date_of_birth, date_modified, user_modified) VALUES ('$username', '$email', SHA1('$password'), '$dob', '$date_modified', '$email')";
                mysqli_query($connect, "SET NAMES 'utf8'");
                
    
                $result_query = mysqli_query($connect, $query); 
                if($result_query){

                    $message = "";
                    $result_code = "";
                    $message = "Đăng ký thành công";
                    $result_code = 200;
                }else{
                    $message = "";
                    $result_code = "";
                    $message = "Đăng ký không thành công";
                    $result_code = 501;
                }
            }else{
                $message = "";
                $result_code = "";
                $message = "Email đã được đăng ký";
                $result_code = 501;
            }
            
        } else {

            $message = "";
            $result_code = "";
            $message = "Input Invalid";
            $result_code = 501;
        }
    
    } // END MAIN IF

    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);
