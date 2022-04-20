<?php
require_once('includes/checkAdmin.php');    
function getBookAuthors($authorList, $authorIDs){
    $authors = [];
    $authorIDs = explode(',', $authorIDs);
    foreach($authorList as $author){
        if(in_array($author['AuthorID'], $authorIDs)){
           $authors[] = $author['Name'];
        }
    }
    return implode(', ', $authors);
}

function getBookGenres($genreList, $genreIDs){
    $genres = [];
    $genreIDs = explode(',', $genreIDs);
    foreach($genreList as $genre){
        if(in_array($genre['GenreID'], $genreIDs)){
           $genres[] = $genre['Name'];
        }
    }
    return implode(', ', $genres);
}

$cssFiles = '
<link rel="stylesheet" href="assets/css/adminPanel.css" />
<link href="//cdn.muicss.com/mui-0.10.3/css/mui.min.css" rel="stylesheet" type="text/css" />
';
$jsFiles = '
<script src="//cdn.muicss.com/mui-0.10.3/js/mui.min.js"></script>
';
require_once('includes/header.php');
require_once('includes/Database.php');

$dbc = new DbConnect();
$authors = $dbc->query("SELECT * FROM Author");
$genres = $dbc->query("SELECT * FROM Genre");
$books = $dbc->query("SELECT ISBN,Title, Edition, Year, Summary, Price, Image, Quantity, GROUP_CONCAT(Book_author.AuthorID) as authors, GROUP_CONCAT(Book_genre.GenreID) as genres FROM Book
    LEFT JOIN Book_author on Book.ISBN = Book_author.BookISBN 
    LEFT JOIN Book_genre on Book.ISBN = Book_genre.BookISBN 
    GROUP By ISBN
");

$title=isset($_SESSION['title'])?$_SESSION['title']:'';
$summary=isset($_SESSION['summary'])?$_SESSION['summary']:'';
$year=isset($_SESSION['year'])?$_SESSION['year']:'';
$isbn=isset($_SESSION['isbn'])?$_SESSION['isbn']:'';
$authorsList=isset($_SESSION['authors'])?$_SESSION['authors']:'';
$genresList=isset($_SESSION['genres'])?$_SESSION['genres']:'';
$edition=isset($_SESSION['edition'])?$_SESSION['edition']:'';
$quantity=isset($_SESSION['quantity'])?$_SESSION['quantity']:'';
$price=isset($_SESSION['price'])?$_SESSION['price']:'';
?>
<div class="add_book">
    <div class="addForm">
        <?php
            if(isset($_SESSION['message'])){
                echo '<div class="mui-panel">';
                echo '<p>'.$_SESSION['message'].'</p>';
                echo '</div>';
                unset($_SESSION['message']);
            }
        ?>
        <form class="mui-form" method="post" action="handle_book.php?action=add" enctype="multipart/form-data">
            <legend>Add a book</legend>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="text" name="Title" maxlength="300" value="<?php  echo str_replace('"', '&quot;', $title); ?>" required>
                <label>Title</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label" > 
                <input type="text" name="ISBN" pattern="\d{13}" value="<?php  echo str_replace('"', '&quot;', $isbn); ?>" required>
                <label>ISBN</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="text" name="Edition" pattern="\d{1,11}" value="<?php  echo str_replace('"', '&quot;', $edition); ?>">
                <label>Edition</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label" >
                <input type="text" name="Year" pattern="\d{4}" value="<?php  echo str_replace('"', '&quot;', $year); ?>">
                <label>Published Year</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label">
                <input type="text" name="Quantity" pattern="\d{1,11}" value="<?php  echo str_replace('"', '&quot;', $quantity); ?>" required>
                <label>Quantity</label>
            </div>
            <div class="mui-textfield mui-textfield--float-label" >
                <input type="text" name="Price" pattern="\d{1,11}" value="<?php  echo str_replace('"', '&quot;', $price); ?>" required>
                <label>Price</label>
            </div>
            <div>
                <label for="genre">Genre</label>
                <select name="genres" multiple required>
                    <?php
                foreach($genres as $genre){
                    echo "<option value='{$genre['id']}'>{$genre['Name']}</option>";
                }
                ?>

                </select>
            </div>
            <div>
                <label for="author">Author</label>
                <select name="authors" multiple required>
                    <?php
                foreach($authors as $author){
                    echo "<option value='{$author['AuthorID']}'>{$author['Name']}</option>";
                }
                ?>
                </select>
            </div>
            <?php
                    $query = "SELECT min(Year) as `from`, max(Year) as `until` FROM book";
                    $years = $dbc->query($query);
                    $year = $years[0];
                    $from = $year['from'];
                    $until = $year['until'];
                ?>
            <input type="file" class="custom-file-input" name="image" accept="image/*" />
            <div class="mui-textfield">
                <textarea name="Summary"><?php echo htmlspecialchars($summary); ?></textarea>
                <label>Summary</label>
            </div>
            <button type="submit" class="mui-btn mui-btn--raised">Submit</button>
        </form>
    </div>
    <table class="mui-table  mui-table--bordered">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>Summary</th>
            <th>ISBN</th>
            <th>Remained</th>
            <th>Action</th>
        </tr>
        <?php
    foreach($books as $book){
        echo '<tr>';
        echo '<td>'.$book['Title'].'</td>';
        echo '<td>'.getBookAuthors($authors,$book['authors']).'</td>';
        echo '<td>'.getBookGenres($genres,$book['genres']).'</td>';
        echo '<td>'.$book['Year'].'</td>';
        echo '<td>'.$book['Summary'].'</td>';
        echo '<td>'.$book['ISBN'].'</td>';
        echo '<td>'.$book['Quantity'].'</td>';
        echo '<td><a href="editBook.php?isbn='.$book['ISBN'].'">Edit</a> | <a href="deleteBook.php?isbn='.$book['ISBN'].'">Delete</a></td>';
        echo '</tr>';
    }
    ?>
    </table>



</div>
<div class="add_author">
    <form class="mui-form" method="post" action="handle_author.php?action=add">
        <legend>Add an author</legend>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" name="Name" maxlength="300">
            <label>Name</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" name="Birthday" pattern="\d{4}">
            <label>Birth Year</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" name="Deathday" pattern="\d{4}">
            <label>Death Year</label>
        </div>
        <div class="mui-textfield">
            <textarea name="Description"></textarea>
            <label>Description</label>
        </div>
        <input type="file" class="custom-file-input" name="author_image" accept="image/*" />

        <button type="submit" class="mui-btn mui-btn--raised">Add Author</button>
    </form>
</div>
<div class="add_genre">
    <form class="mui-form" method="post" action="handle_genre.php?action=add">
        <legend>Add a genre</legend>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" name="Name" maxlength="300">
            <label>Name</label>
        </div>
        <div class="mui-textfield">
            <textarea name="Description"></textarea>
            <label>Description</label>
        </div>
        <input type="file" class="custom-file-input" name="genre_image" accept="image/*" />

        <button type="submit" class="mui-btn mui-btn--raised">Add Genre</button>
</div>
<?php
require_once('includes/footer.php');
?>