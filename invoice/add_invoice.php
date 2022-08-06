<?php 

    include_once '../config/connect_db.php';
    include_once '../model/invoice.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Bat dau xu ly form. Tao bien $errors
        $errors = array();

        if(isset($_POST['seller']) && filter_var($_POST['seller'], FILTER_DEFAULT)) {
            $seller = mysqli_real_escape_string($connect, $_POST['seller']); 
        } else {
            $errors[] = 'seller';
        }

        if(isset($_POST['address']) && filter_var($_POST['address'], FILTER_DEFAULT)) {
            $address = mysqli_real_escape_string($connect, $_POST['address']); 
        } else {
            $errors[] = 'address';
        }

        if(isset($_POST['totalcost']) && filter_var($_POST['totalcost'], FILTER_DEFAULT)) {
            $totalcost = mysqli_real_escape_string($connect, $_POST['totalcost']); 
            $totalcost = (float)$totalcost;
        } else {
            $errors[] = 'totalcost';
        }

        if(isset($_POST['timestamp']) && filter_var($_POST['timestamp'], FILTER_DEFAULT)) {
            $timestamp = mysqli_real_escape_string($connect, $_POST['timestamp']); 
        } else {
            $errors[] = 'timestamp';
        }

        if(isset($_POST['uid']) && filter_var($_POST['uid'], FILTER_DEFAULT)) {
            $uid = mysqli_real_escape_string($connect, $_POST['uid']); 
            $uid = (int)$uid;
        } else {
            $errors[] = 'uid';
        }

        // echo $errors[0];

        if(empty($errors)) {

            mysqli_query($connect, "SET NAMES 'utf8'");

            $query_uid = "SELECT id FROM user WHERE id = '{$uid}' ";   
            $result_uid = mysqli_query($connect, $query_uid);

            if(mysqli_num_rows($result_uid) == 1){
                // $query = "INSERT INTO invoice (address, seller, total_cost, time_stamp, date_modified, user_id) VALUES ('$address', '$seller', '$totalcost', '$timestamp', '$date_modified', '$uid')";
                $query = "INSERT INTO invoice (address, seller, total_cost, time_stamp, date_modified, user_id) VALUES ('$address', '$seller', '$totalcost', '$timestamp', CURRENT_TIME(), '$uid')";
                $result_query = mysqli_query($connect, $query); 
    
                if($result_query){
                    $query_invoice = "SELECT id FROM invoice where user_id =  '$uid' ORDER BY date_modified DESC LIMIT 1";
                    $result_invoice = mysqli_query($connect, $query_invoice);
                    if(mysqli_num_rows($result_invoice) == 1){
                        $row = mysqli_fetch_assoc($result_invoice);
                        $id = $row["id"];

                        $message = "";
                        $result_code = "";
                        $message =$id;
                        $result_code = 200;
                    }else{
                        $message = "";
                        $result_code = "";
                        $message = "Failed";
                        $result_code = 501;
                    }
                }else{
                    $message = "";
                    $result_code = "";
                    $message = "Insert Invoice Failed";
                    $result_code = 501;
                }
            }else{
                $message = "";
                $result_code = "";
                $message = "Id not exist";
                $result_code = 501;
            }
            
        } else {
            $message = "";
            $result_code = "";
            $message = "Input Invalid";
            $result_code = 501;
        }

        // echo $message;
    }
    $result = "";
    $result = $result_code."#".$message;

    header('Content-Type: application/json');
    echo json_encode($result);
?>
