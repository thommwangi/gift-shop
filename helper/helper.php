<?php
function display_errors($errors){
         //$sqli=$mysqli = new mysqli("localhost", "root", "", "giftit");
        $display = '<ul class="bg-danger">';
        foreach($errors as $error){
            $display .='<li class="text-danger">'.$error.'</li>';
        }
        $display .='</ul>';
        return $display;
    }
	
	function sanitize($dirty){
		
		return htmlentities($dirty,ENT_QUOTES, "UTF-8");
	}
	function money($number){
		return 'Ksh' .number_format($number,2);
    }
    function login($user_id){
        //creating session for a user and updating the database
        
        $_SESSION['SBUser'] = $user_id;
        global $mysqli;
        $date = date("Y-m-d H:i:s");
        $mysqli->query("UPDATE users SET last_login='$date' WHERE id='$user_id'"); 
        $_SESSION['success_flash'] ='You are now logged in';
        header('Location: index.php'); 
     }
     function is_logged_in(){
         if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
             return true;
         }
         return false;
     }
     function login_error_redirect($url = 'login.php'){
         $_SESSION['error_flash'] = 'You must be logged in to access this page';
         header('Location: ' .$url);
     }
     function permission_error_redirect($url = 'login.php'){
        $_SESSION['error_flash'] = 'You do not have permission to access this page';
        header('Location: ' .$url);
    }
     function has_permission($permission = 'admin'){
         global $user_data;
         $permissions = explode(',', $user_data['permissions']);//var_dump($permissions);die();
         if(in_array($permission,$permissions,true)){
             return true;
         }
         return false;
     }
     //function for formatting date from database to display on users table
     function pretty_date($date){
        return date("M d, Y h:i A",strtotime($date));
     }
?>