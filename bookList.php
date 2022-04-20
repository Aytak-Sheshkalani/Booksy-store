<?php
$cssFiles = '
<link rel="stylesheet" href="assets/css/booklist.css" />
<link href="//cdn.muicss.com/mui-0.10.3/css/mui.min.css" rel="stylesheet" type="text/css" />
';
$jsFiles = '
<script src="//cdn.muicss.com/mui-0.10.3/js/mui.min.js"></script>
';
require_once('includes/header.php');
require_once('includes/Database.php');
function defineText($remained){
    if($remained > 5){
        return '<span class="available">Available!</span>';
    }elseif($remained > 0){
        return '<span class="almost-gone">Hurry up! only '.$remained.' remained!</span>';
    }
    return '<span class="unavailable">Out of stock!</span>';
}
$dbc = new DbConnect();
function getSearchQuery(){
    $authorCond = '';
    if(isset($_GET['author']) && !empty($_GET['author'])){
        $authorCond = " and Author.AuthorID='".$_GET['author']."'";
    }
    $genreCond = '';
    if(isset($_GET['genre']) && !empty($_GET['genre'])){
        $genreCond =  " and Genre.GenreID = '".$_GET['genre']."'";
    }


    $query = "SELECT * FROM Book ";
    if($authorCond){
        $query .= "inner join (Select ISBN, GROUP_CONCAT(Author.Name) as Authors from Author, Book_author,Book where Book_author.AuthorID = Author.AuthorID and Book.ISBN = Book_author.BookISBN $authorCond GROUP BY Book.ISBN) as Book_author on Book.ISBN = Book_Author.ISBN ";
    }else{
        $query .="left join (Select ISBN, GROUP_CONCAT(Author.Name) as Authors from Author, Book_author,Book where Book_author.AuthorID = Author.AuthorID and Book.ISBN = Book_author.BookISBN $authorCond GROUP BY Book.ISBN) as Book_author on Book.ISBN = Book_Author.ISBN ";
    }

    if($genreCond){
        $query .= "inner join (Select ISBN, GROUP_CONCAT(Genre.Name) as Genres from Genre, Book_genre,Book where Book_genre.GenreID = Genre.GenreID and Book.ISBN = Book_genre.BookISBN $genreCond GROUP BY Book.ISBN) as Book_genre on Book.ISBN = Book_genre.ISBN";
    }else{
        $query .="left join (Select ISBN, GROUP_CONCAT(Genre.Name) as Genres from Genre, Book_genre,Book where Book_genre.GenreID = Genre.GenreID and Book.ISBN = Book_genre.BookISBN $genreCond GROUP BY Book.ISBN) as Book_genre on Book.ISBN = Book_genre.ISBN";
    }
    $conditions = [];
    if(isset($_GET['search']) && !empty($_GET['search'])){
        $conditions[] = "(Title LIKE '%".$_GET['search']."%' or Summary LIKE '%".$_GET['search']."%' or Book_author.Authors LIKE '%".$_GET['search']."%' or Book_genre.Genres LIKE '%".$_GET['search']."%')";
    }
    if(isset($_GET['published_after']) && !empty($_GET['published_after'])){
        $conditions[] = "Year >= ".$_GET['published_after'];
    }
    if(isset($_GET['published_before']) && !empty($_GET['published_before'])){
        $conditions[] = "Year <= ".$_GET['published_before'];
    }
    if(count($conditions) > 0){
        $query .= " WHERE ".implode(' and ', $conditions);
    }
    return $query;
}
$search=null;
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search=$_GET['search'];
}
$published_after=null;
if(isset($_GET['published_after']) && !empty($_GET['published_after'])){
    $published_after = $_GET['published_after'];
}
$published_before=null;
if(isset($_GET['published_before']) && !empty($_GET['published_before'])){
    $published_before = $_GET['published_before'];
}
$author=null;
if(isset($_GET['author']) && !empty($_GET['author'])){
    $authorInput = $_GET['author'];
}
$genre=null;
if(isset($_GET['genre']) && !empty($_GET['genre'])){
    $genre = $_GET['genre'];
}


?>
<div class="list_container">
    <div class="filters">
        <form class="mui-form">
            <legend>Filter</legend>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="text" name="search" value="<?php echo str_replace('"', '&quot;', $search);?>">
                <label>Search</label>
            </div>
            <div class="mui-select">
                <select name="genre">
                    <option value="">All</option>
                    <?php
                        $query = "SELECT GenreID as id,Name FROM Genre";
                        $genres = $dbc->query($query);
                        foreach($genres as $genre){
                            echo "<option value='{$genre['id']}'>{$genre['Name']}</option>";
                        }
                    ?>

                </select>
                <label>Genre</label>
            </div>
            <div class="mui-select">
                <select name="author">
                    <option value="">All</option>
                    <?php
                    $query = "SELECT * FROM Author";
                    $authors = $dbc->query($query);
                    foreach($authors as $author){
                        $selected = $author['AuthorID'] == $authorInput ? 'selected' : '';
                        echo "<option value='{$author['AuthorID']}' $selected>{$author['Name']}</option>";
                    }
                ?>
                </select>
                <label>Author</label>
            </div>
            <?php
                    $query = "SELECT min(Year) as `from`, max(Year) as `until` FROM book";
                    $years = $dbc->query($query);
                    $year = $years[0];
                    $from = $year['from'];
                    $until = $year['until'];
                ?>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="number" name="published_after" min="<?php echo $from;?>" max="<?php echo $until;?>" value="<?php echo str_replace('"', '&quot;', $published_after);?>">
                <label>Published after</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="number" name="published_before" min="<?php echo $from;?>" max="<?php echo $until;?>" value="<?php echo str_replace('"', '&quot;', $published_before);?>">
                <label>Published before</label>
            </div>

            <button type="submit" class="mui-btn mui-btn--raised">Submit</button>
        </form>
    </div>
    <div class="book_list">
        <h2>Search Results</h2>
        <div>
            <?php
            $q= getSearchQuery();
            $books = $dbc->query($q);
            foreach($books as $book){ ?>
            <a href='bookDetail.php?id=<?php echo $book['ISBN']; ?>'>
                <div class='book'>
                    <div class="availability">
                        <?php echo defineText($book['Quantity']);?>
                    </div>
                    <?php
                    echo strlen(trim($book['Image']))===0;
                    ?>
                    <img src='assets/images/books/<?php echo (strlen(trim($book['Image']))!=0) ? trim($book['Image']) : 'no-image.jpg'; ?>' />
                    <div class='description'>
                        <h3><?php echo $book['Title']; ?></h3>
                        <p><?php echo $book['Summary']; ?></p>
                        <p>Price: $<?php echo $book['Price']; ?></p>
                        <p>Authors: <?php echo $book['Authors']; ?></p>
                        <p>Genres: <?php echo $book['Genres']; ?></p>
                    </div>
                </div>
            </a>
            <? } ?>
        </div>
    </div>
</div>
</div>
<?php
require_once('includes/footer.php');
?>