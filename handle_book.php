<?php
// Aytak Sheshkalani Ghalibaf 8741242

require_once('includes/checkAdmin.php');    
require_once('includes/Database.php');
require_once('includes/getUUid.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$dbc = new DbConnect();
if($action=='delete'){
    $bookID = $_GET['bookID'];
    $query = "DELETE FROM Book WHERE BookID = '$bookID'";
    $dbc->query($query);
    header('Location: adminPanel.php');
    exit();
}elseif($action=='add'){
    $_SESSION['isbn'] = $_POST['ISBN'];
    $_SESSION['title'] = $_POST['Title'];
    $_SESSION['summary'] = $_POST['Summary'];
    $_SESSION['year'] = $_POST['Year'];
    $_SESSION['authors'] = $_POST['authors'];
    $_SESSION['genres'] = $_POST['genres'];
    $_SESSION['price'] = $_POST['Price'];
    $_SESSION['quantity'] = $_POST['Quantity'];
    $_SESSION['edition'] = $_POST['Edition'];

    print_r($_POST);



    $params =[];
    $params[] = ["value"=>$_POST['Title'], "type"=> 's'];
    $params[] = ["value"=>$_POST['ISBN'], "type"=> 's'];
    $params[] = ["value"=>$_POST['Edition'], "type"=> 'i'];
    $params[] = ["value"=>$_POST['Year'], "type"=> 'i'];
    $params[] = ["value"=>$_POST['Quantity'], "type"=> 'i'];
    $params[] = ["value"=>$_POST['Price'], "type"=> 'i'];
    $params[] = ["value"=>null, "type"=> 's'];
    $params[] = ["value"=>$_POST['Summary'], "type"=> 's'];
    
    $bookID = $_POST['ISBN'];
    
    $query = "INSERT INTO Book (`Title`, `ISBN`,`Edition`,`Year`, `Quantity`,`Price`,`Image`,`Summary`) VALUES (?,?,?,?,?,?,?,?)";
    $res = $dbc->query($query, $params,false);
    if($res->error){
        $_SESSION['message'] = 'Error: '.$res->error;
        header('Location: adminPanel.php');
        exit();
    }
    $authors = $_POST['authors'];
    foreach($authors as $author){
        $query = "INSERT INTO Book_author (BookISBN, AuthorID) VALUES ('$bookID', '$author')";
        $dbc->query($query);
    }
    $genres = $_POST['genres'];
    foreach($genres as $genre){
        $query = "INSERT INTO Book_genre (BookISBN, GenreID) VALUES ('$bookID', '$genre')";
        $dbc->query($query);
    }


    if($_FILES['image'] && $_FILES['image']['error']==0){

        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
        $name = guidv4().'.'.$imageFileType;
        $target_dir = "assets/images/books/";
        $target_file = $target_dir . $name;
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $_SESSION['message'] = 'Error: '.$dbc->get_dbc()->error;
        }else{
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $query = "UPDATE Book SET Image = '$name' WHERE ISBN = '$bookID'";
                $res = $dbc->query($query,[],false);
                if($res->error){
                    $_SESSION['message'] = 'Error: '.$res->error;
                    header('Location: adminPanel.php');
                    exit();
                }
                $_SESSION['message'] = 'Book added successfully';
                // header('Location: adminPanel.php');
                // exit();
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                header('Location: adminPanel.php');
                exit();
            }
        }
    }else{
        $_SESSION['message'] = 'Book added successfully';
        header('Location: adminPanel.php');
        exit();
    }
    header('Location: adminPanel.php');
    exit();
}
// elseif($action=='edit'){
//     $query = "SELECT * FROM Book WHERE BookID = '$bookID'";
//     $result = $dbc->query($query);
//     $book = $result->fetch_assoc();
//     $query = "SELECT * FROM Book_author WHERE BookISBN = '$bookID'";
//     $result = $dbc->query($query);
//     $authors = [];
//     while($row = $result->fetch_assoc()){
//         $authors[] = $row['AuthorID'];
//     }
//     $query = "SELECT * FROM Book_genre WHERE BookISBN = '$bookID'";
//     $result = $dbc->query($query);
//     $genres = [];
//     while($row = $result->fetch_assoc()){
//         $genres[] = $row['GenreID'];
//     }
// }elseif($action=='update'){
//     $bookID = $_GET['bookID'];
//     $title = $_GET['title'];
//     $summary = $_GET['summary'];
//     $year = $_GET['year'];
//     $isbn = $_GET['isbn'];
//     $authors = $_GET['authors'];
//     $genres = $_GET['genres'];
//     $query = "UPDATE Book SET Title = '$title', Summary = '$summary', Year = '$year', ISBN = '$isbn' WHERE BookID = '$bookID'";
//     $dbc->query($query);
//     $query = "DELETE FROM Book_author WHERE BookISBN = '$bookID'";
//     $dbc->query($query);
//     $query = "DELETE FROM Book_genre WHERE BookISBN = '$bookID'";
//     $dbc->query($query);
//     foreach($authors as $author){
//         $query = "INSERT INTO Book_author (BookISBN, AuthorID) VALUES ('$bookID', '$author')";
//         $dbc->query($query);
//     }
//     foreach($genres as $genre){
//         $query = "INSERT INTO Book_genre (BookISBN, GenreID) VALUES ('$bookID', '$genre')";
//         $dbc->query($query);
//     }
// }