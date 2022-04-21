<?php
// Aytak Sheshkalani Ghalibaf 8741242
require_once('includes/getUUid.php');
require_once('includes/checkAdmin.php');    
require_once('includes/Database.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$dbc = new DbConnect();

if($action=='add'){
    $authorId =  guidv4();
    $imageName = null;
    if($_FILES['author_image'] && $_FILES['author_image']['error']==0){

        $imageFileType = strtolower(pathinfo($_FILES["author_image"]["name"],PATHINFO_EXTENSION));
        $name = $imageName = $authorId.'.'.$imageFileType;
        $target_dir = "assets/images/authors/";
        $target_file = $target_dir . $name;
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['auth_message'] = 'Error: '.$dbc->get_dbc()->error;
        }else if (!move_uploaded_file($_FILES["author_image"]["tmp_name"], $target_file)) {
                $_SESSION['auth_message'] = "Sorry, there was an error uploading your file.";
                header('Location: adminPanel.php#authorform');
                exit();
        }
    }
    $author = $_POST['Name'];
    $birthday = $_POST['Birthday'];
    $description = strlen($_POST['Description'])!==0? "'{$dbc->prepare_string($_POST['Description'])}'," : '';
    $query = "INSERT INTO Author (`AuthorID`, `Name`, `Birthday`, `Author_image`, `Description`) VALUES (?,?,?,?,?)";
    $params = [
        ["value"=>$authorId, "type"=> 's'],
        ["value"=>$author, "type"=> 's'],
        ["value"=>$birthday, "type"=> 's'],
        ["value"=> null , "type"=> 's'],
        ["value"=>$imageName, "type"=> 's'],
    ];
    $res = $dbc->query($query, $params,false);
    if($res->error){
        $_SESSION['auth_message'] = 'Error: '.$res->error;
        header('Location: adminPanel.php#authorform');
        exit();
    }
    $_SESSION['auth_message'] = 'Successfully added new Author!';

    header('Location: adminPanel.php#authorform');
    exit();
}