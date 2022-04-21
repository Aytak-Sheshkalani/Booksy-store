<?php
// Aytak Sheshkalani Ghalibaf 8741242
require_once('includes/getUUid.php');
require_once('includes/checkAdmin.php');    
require_once('includes/Database.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$dbc = new DbConnect();

if($action="add"){
    if(isset($_POST['Name']) && isset($_POST['Description'])){
        $genreName = $_POST['Name'];
        $description = $_POST['Description'];
        $genreId= guidv4();
        $query = "INSERT INTO Genre (`GenreID`, `Name`, `Description`) VALUES (?,?,?)";
        $params =[];
        $params[] = ["value"=> $genreId, "type"=> 's'];
        $params[] = ["value"=>$_POST['Name'], "type"=> 's'];
        $params[] = ["value"=>$_POST['Description'], "type"=> 's'];
        $res = $dbc->query($query, $params,false);
        if($res->error){
            $_SESSION['genre_message'] = 'Error: '.$res->error;
            header('Location: adminPanel.php#genreform');
            exit();
        }
        $_SESSION['genre_message'] = 'Successfully added genre: '.$genreName;
    }
    header('Location: adminPanel.php#genreform');
    exit();
}