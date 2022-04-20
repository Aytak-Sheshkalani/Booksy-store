<?php
$cssFiles = '
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet"  href="assets/css/slidestyle.css" />';
require_once('includes/header.php');
?>


      <!-- Example row of columns -->
      <p class="lead" style="margin: 25px 0"><a href="index.php">Books</a> > <?php echo "Be aTriangle" ; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img class="img-responsive img-thumbnail" src="./images/BE A TRIANGLE.png">
        </div>
        <div class="col-md-6">
          <h4>Book Description</h4>
          <p><?php echo "ABOUT BE A TRIANGLE
From the New York Times bestselling author of How to Be a Bawse comes an “insightful and charmingly funny” (Rupi Kaur) primer on learning to come home to your truest and happiest self.“I love Lilly’s honest and helpful advice about achieving happiness.”—Mindy Kaling, #1 New York Times bestselling author of Why Not Me?"; ?></p>
          <h4>Book Details</h4>
          <table class="table">
          
            <tr>
              <td>ISBN</td>
              <td>9780593357811</td>
            </tr>
			   <tr>
              <td>Author</td>
              <td>Lilly Singh</td>
            </tr>
			   <tr>
              <td>Price</td>
              <td>20.00 $</td>
            </tr>
           
          </table>
          <form method="post" action="cart.php">
            <input type="hidden" name="ISBN" value="<?php echo $book_isbn;?>">
            <input type="submit" value="Purchase / Add to cart" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>

<?php
require_once('includes/footer.php');
?>