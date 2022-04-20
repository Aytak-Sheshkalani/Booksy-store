<?php
// Aytak Sheshkalani Ghalibaf 8741242

// First we verify that user is admin and logged in
function isUserAdmin(){
    if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'){
        return true;
    }
    return false;    
}
session_start();
if(!isUserAdmin()){
    header('Location: index.php');
    exit();
}