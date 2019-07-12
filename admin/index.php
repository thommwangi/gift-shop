<?php

require_once '../core/init.php'; 
//include '../helper/helper.php' ;
if(!is_logged_in()){
    header('Location: login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';



?> 
<style>
body{
  background-image:url("../images/admin3.jpg"); 
   background-size: 100vw 100vh; 
   
    background-attachment:fixed; 
}
</style>
Administrator Home
<?php include 'includes/footer.php'; ?>