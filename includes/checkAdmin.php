<?php
// First we verify that user is admin and logged in
function isUserAdmin(){
    if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'){
        return true;
    }
    return false;    
}
session_start();
if(!isUserAdmin() && false){
    header('Location: index.php');
    exit();
}