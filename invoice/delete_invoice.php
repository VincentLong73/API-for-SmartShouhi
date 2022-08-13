<?php 

    include_once '../config/connect_db.php';

    $db = new ConnectDatabase();
    $connect = $db->connect();
    $result_code = 404;
    $message = "Not Found";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        mysqli_query($connect, "SET NAMES 'utf8'");

        $invoiceId = $_POST['invoiceId'];

        $query_select = "SELECT id FROM invoice WHERE id = '{$invoiceId}'";
        $result_select_invoice = mysqli_query($connect, $query_select);
        
        if(mysqli_num_rows($result_select_invoice) == 1) {

            $query_delete_item = "DELETE FROM item WHERE invoice_id = '{$invoiceId}' ";
            $result_delete_item = mysqli_query($connect, $query_delete_item); 
            if($result_delete_item){
                $query_delete_invoice = "DELETE FROM invoice WHERE id = '{$invoiceId}' ";  
                $result_delete_invoice = mysqli_query($connect, $query_delete_invoice);

                if($result_delete_invoice) {
                    $message = "";
                    $result_code = "";
                    $message = "Xóa hóa đơn thành công";
                    $result_code = 200;
                } else {
                    $message = "";
                    $result_code = "";
                    $message = "Xóa hóa đơn không thành công";
                    $result_code = 501;
                }
            }else{
                $message = "";
                $result_code = "";
                $message = "Xóa hóa đơn không thành công";
                $result_code = 501;
            }
            
        } else {
            $message = "";
            $result_code = "";
            $message = "Hóa đơn không tồn tại";
            $result_code = 501;
        }
 
    }
    $result = "";
    $result = $result_code."#".$message;

    header("Content-type: text/html","charset=utf-8");
    echo html_entity_decode($result);
    
?>
