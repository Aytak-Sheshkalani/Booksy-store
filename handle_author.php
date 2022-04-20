<?php
require_once('includes/checkAdmin.php');    
require_once('includes/Database.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$dbc = new DbConnect();

if($action=='delete'){
    $bookID = $_GET['bookID'];
    $query = "DELETE FROM Book WHERE BookID = '$bookID'";
    $dbc->query($query);
    header('Location: adminPanel.php');
    exit();
}elseif($action=='edit'){
    $query = "SELECT * FROM Book WHERE BookID = '$bookID'";
    $result = $dbc->query($query);
    $book = $result->fetch_assoc();
    $query = "SELECT * FROM Book_author WHERE BookISBN = '$bookID'";
    $result = $dbc->query($query);
    $authors = [];
    while($row = $result->fetch_assoc()){
        $authors[] = $row['AuthorID'];
    }
    $query = "SELECT * FROM Book_genre WHERE BookISBN = '$bookID'";
    $result = $dbc->query($query);
    $genres = [];
    while($row = $result->fetch_assoc()){
        $genres[] = $row['GenreID'];
    }
}elseif($action=='update'){
    $bookID = $_GET['bookID'];
    $title = $_GET['title'];
    $summary = $_GET['summary'];
    $year = $_GET['year'];
    $isbn = $_GET['isbn'];
    $authors = $_GET['authors'];
    $genres = $_GET['genres'];
    $query = "UPDATE Book SET Title = '$title', Summary = '$summary', Year = '$year', ISBN = '$isbn' WHERE BookID = '$bookID'";
    $dbc->query($query);
    $query = "DELETE FROM Book_author WHERE BookISBN = '$bookID'";
    $dbc->query($query);
    $query = "DELETE FROM Book_genre WHERE BookISBN = '$bookID'";
    $dbc->query($query);
    foreach($authors as $author){
        $query = "INSERT INTO Book_author (BookISBN, AuthorID) VALUES ('$bookID', '$author')";
        $dbc->query($query);
    }
    foreach($genres as $genre){
        $query = "INSERT INTO Book_genre (BookISBN, GenreID) VALUES ('$bookID', '$genre')";
        $dbc->query($query);
    }
    header('Location: adminPanel.php');
    exit();
}elseif($action=='add'){
    $title = $_GET['title'];
    $summary = $_GET['summary'];
    $year = $_GET['year'];
    $isbn = $_GET['isbn'];
    $authors = $_GET['authors'];
    $genres = $_GET['genres'];
    $query = "INSERT INTO Book (Title, Summary, Year, ISBN) VALUES ('$title', '$summary', '$year', '$isbn')";
    $dbc->query($query);
    $bookID = $dbc->get_dbc()->insert_id;
    foreach($authors as $author){
        $query = "INSERT INTO Book_author (BookISBN, AuthorID) VALUES ('$bookID', '$author')";
        $dbc->query($query);
    }
    foreach($genres as $genre){
        $query = "INSERT INTO Book_genre (BookISBN, GenreID) VALUES ('$bookID', '$genre')";
        $dbc->query($query);
    }
    header('Location: adminPanel.php');
    exit();
}