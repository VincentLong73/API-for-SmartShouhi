<?php 

    include_once '../config/connect_db.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $invoiceId = $_POST['invoiceId'];
        $seller = $_POST['seller'];
        $address = $_POST['address'];
        $totalcost = $_POST['totalcost'];
        $timestamp = $_POST['timestamp'];

        mysqli_query($connect, "SET NAMES 'utf8'");

        $query_invoice = "SELECT * FROM invoice WHERE id = '{$invoiceId}' ";  
        $result_invoice = mysqli_query($connect, $query_invoice); 
        if(mysqli_num_rows($result_invoice) == 1){
            $query_update_invoice = "UPDATE invoice SET address = '{$address}', seller = '{$seller}', total_cost = '{$totalcost}', time_stamp = '{$timestamp}' WHERE id = '{$invoiceId}' ";  
            $result_update_invoice = mysqli_query($connect, $query_update_invoice); 
            
            if($result_update_invoice) {

                $message = "";
                $result_code = "";
                $message = "Cập nhật thành công";
                $result_code = 200;
                
            } else {
                $message = "";
                $result_code = "";
                $message = "Cập nhật không thành công";
                $result_code = 501;
            }
        }else{
            $message = "";
            $result_code = "";
            $message = "Hóa đơn không tồn tại";
            $result_code = 501;
        }


    } else {
        // $message = "Please fill in all the required fields";
        $message = "";
        $result_code = "";
        $message = "Vui lòng nhập đủ thông tin các trường";
        $result_code = 501;
    }

    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);
    
?>
