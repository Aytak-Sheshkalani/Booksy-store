<?php
require_once('includes/Database.php');
$dbc = new DbConnect();
if(!isset($_GET['isbn'])){
  header('Location: index.php');
}
$isbn = $_GET['isbn'];
// get book by isbn from mysql
$query = "SELECT * FROM Book WHERE ISBN = '$isbn'";
$book = $dbc->query($query);
$book = $book[0];

$authorsql = "SELECT * FROM Author, Book_author WHERE Book_author.BookISBN = '$isbn' and Book_author.AuthorID = Author.AuthorID";
$authors = @$dbc->query($authorsql);

$genreSql = "SELECT * FROM Genre, Book_genre WHERE Book_genre.BookISBN = '$isbn' and Book_genre.GenreID = Genre.GenreID";
$genres = @$dbc->query($genreSql);

$cssFiles = '
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet"  href="assets/css/slidestyle.css" />';
require_once('includes/header.php');

?>


      <!-- Example row of columns -->
      <p class="lead" style="margin: 25px 0"><a href="index.php">Books</a> > <?php echo "Be aTriangle" ; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img  class="img-responsive img-thumbnail" src='assets/images/books/<?php echo (strlen(trim($book['Image']))!=0) ? trim($book['Image']) : 'no-image.jpg'; ?>' />

        </div>
        <div class="col-md-6">
          <h4>Book Description</h4>
          <p><?php echo $book['Summary'] ?></p>
          <h4>Book Details</h4>
          <table class="table">
          
            <tr>
              <td>ISBN</td>
              <td><?php echo $book['ISBN']; ?></td>
            </tr>
			   <tr>
              <td>Author</td>
              <td><?php
              if(count($authors) > 0){
                foreach($authors as $author){
                  echo $author['Name'] . '<br>';
                }
              }
              ?></td>
            </tr>
			   <tr>
              <td>Price</td>
              <td>$<?php
                echo $book['Price'];
              ?>
              </td>
            </tr>
           
          </table>
          <form method="post" action="cart.php">
            <input type="hidden" name="ISBN" value="<?php echo $isbn;?>">
            <input type="submit" value="Purchase / Add to cart" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>

<?php
require_once('includes/footer.php');
?>