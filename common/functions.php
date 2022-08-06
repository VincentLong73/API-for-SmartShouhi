<?php
    // Xac dinh hang so cho dia chi tuyet doi
    define('BASE_URL', 'http://localhost/icms/');

    include_once 'config/connect_db.php';

    global $connect_db;
 


    // use our custom handler
    set_error_handler('custom_error_handler');

    // Kiem tra xem nguoi dung da dang nhap hay chua?
    function is_logged_in() {
        if(!isset($_SESSION['uid'])) {
            redirect_to('login.php');
        }
    } // END is_logged_in
      
    // Tai dinh huong nguoi dung ve trang mac dinh la index
    function redirect_to($page = 'index.php') {
        $url = BASE_URL . $page;
        header("Location: $url");
        exit();
    }
    
    // Ham nay de thong bao loi
    function report_error($mgs) {
        if(isset($mgs)) {
            foreach ($mgs as $m) {
                echo $m;
            }
        }
    } // END report_error
       
    // Cat chu de hien thi thanh doan van ngan.
    function the_excerpt($text, $string = 400) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        if(strlen($sanitized) > $string) {
            $cutString = substr($sanitized,0,$string);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
       
    } // End the_excerpt
    
    // Tao paragraph tu CSDL
    function the_content($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return str_replace(array("\r\n", "\n"),array("<p>", "</p>"),$sanitized);
    }
    
    // Ham tao ra de kiem tra xem co phai la admin hay khong
    function is_admin($user_id) {
        global $connect_db;
        

        $query = "SELECT role_name FROM `role` INNER join user where role.id = user.role_id and user.id = '{$user_id}' ";
            
        mysqli_query($connect_db, "SET NAMES 'utf8'");
  
        $result = mysqli_query($connect_db, $query); 
        if($result && $result = 'Admin'){
            return true;
        }
        return false;
    }
    
    // Kiem tra xem nguoi dung co the vao trang admin hay khong?
    function admin_access($user_id) {
        if(!is_admin($user_id)) {
            redirect_to();
        }
    }
    
    // Kiem tra xem $id co hop le, la dang so hay khong?
    function validate_id($id) {
        if(isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' =>1))) {
            $val_id = $id;
            return $val_id;
        } else {
            return NULL;
        }
    } // End validate_id
    
    // Truy van CSDL de lay post va thong tin nguoi dung.
    function get_page_by_id($id) {
        global $dbc;
        $q = " SELECT p.page_name, p.page_id, p.content,"; 
        $q .= " DATE_FORMAT(p.post_on, '%b %d, %y') AS date, ";
        $q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $q .= " FROM pages AS p ";
        $q .= " INNER JOIN users AS u ";
        $q .= " USING (user_id) ";
        $q .= " WHERE p.page_id={$id}";
        $q .= " ORDER BY date ASC LIMIT 1";
        $result = mysqli_query($dbc,$q);
        //confirm_query($result, $q);
        return $result;
    } // End get_page_by_id
    
    
    // Ham de chong spam email
    function clean_email($value) {
        $suspects = array('to:', 'bcc:','cc:','content-type:','mime-version:', 'multipart-mixed:','content-transfer-encoding:');
        foreach ($suspects as $s) {
            if(strpos($value, $s) !== FALSE) {
                return '';
            }
            // Tra ve gia tri cho dau xuong hang
            $value = str_replace(array('\n', '\r', '%0a', '%0d'), '', $value);
            return trim($value);
        }
    }   
   
    // Ham dung de truy xuat du lieu cua nguoi dung.
    function fetch_user($user_id) {
        global $dbc;
        $q = "SELECT * FROM users WHERE user_id = {$user_id}";
        $r = mysqli_query($dbc, $q); 
        //confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0) {
            // Neu co ket qua tra ve
            return $result_set = mysqli_fetch_array($r, MYSQLI_ASSOC);
        } else {
            // Neu ko co ket qua tra ve
            return FALSE;
        }
    } // END fetch_user

    function fetch_users($order) {
        global $dbc;
        
        // Truy van CSDL de lay tat ca thong tin nguoi dung
        $q = "SELECT * FROM users ORDER BY {$order} ASC";
        $r = mysqli_query($dbc,$q); 
        //confirm_query($r, $q);
        
        if(mysqli_num_rows($r) > 1) {
            // Tao ra array de luu lai ket qua
            $users = array();

            // Neu co gia tri de tra ve
            while($results = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $users[] = $results;
        } // End while
        return $users;
        } else {
        return FALSE; // Neu khong co thong tin nguoi dung trong CSDL
        }

    }// End fetch_users

    // Ham de sap xep thu tu cua bang USERS
    function sort_table_users($order) {
        switch ($order) {
            case 'fn':
            $order_by = "first_name";
            break;
            
            case 'ln':
            $order_by = "last_name";
            break;
            
            case 'e':
            $order_by = "email";
            break;
            
            case 'ul':
            $order_by = "user_level";
            break;
            
            default:
            $order_by = "first_name";
            break;
        }
        return $order_by;
    } // END sort_table_users

    // Check connection for OOP
    function check_db_conn() {
        if(mysqli_connect_errno()) {
            echo "Connection failed: ". mysqli_connect_error();
            exit();
        }
    }

    // Check current page for admin page
    function current_page($page) {
        if(basename($_SERVER['SCRIPT_NAME']) == $page) 
            echo "class='here'";
    }
 