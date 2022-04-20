<?php
	
	session_start();
	require_once "functions/database_functions.php";
	require_once "functions/cart_functions.php";

	// book_isbn got from form post method, change this place later.
	if(isset($_POST['ISBN'])){
		$book_isbn = $_POST['ISBN'];
	}

	if(isset($book_isbn)){
		// new item selected
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] is associative array that bookisbn => qty
			$_SESSION['cart'] = array();

			$_SESSION['total_items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}

		if(!isset($_SESSION['cart'][$book_isbn])){
			$_SESSION['cart'][$book_isbn] = 1;
		} elseif(isset($_POST['cart'])){
			$_SESSION['cart'][$book_isbn]++;
			unset($_POST);
		}
	}

	// if save change button is clicked , change the qty of each bookisbn
	if(isset($_POST['save_change'])){
		foreach($_SESSION['cart'] as $isbn =>$qty){
			if($_POST[$isbn] == '0'){
				unset($_SESSION['cart']["$isbn"]);
			} else {
				$_SESSION['cart']["$isbn"] = $_POST["$isbn"];
			}
		}
	}

	
	$title = "Your shopping cart";
	

	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['total_items'] = total_items($_SESSION['cart']);
?>
   	<form action="cart.php" method="post">
	   	<table class="table">
	   		<tr>
	   			<th>Item</th>
	   			<th>Price</th>
	  			<th>Quantity</th>
	   			<th>Total</th>
	   		</tr>
	   		<?php
		    	foreach($_SESSION['cart'] as $isbn => $qty){
					$conn = db_connect();
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
			?>
			<tr>
				<td><?php echo $book['Title'] . " by " . $book['Author']; ?></td>
				<td><?php echo "$" . $book['Price']; ?></td>
				<td><input type="text" value="<?php echo $qty; ?>" size="2" name="<?php echo $isbn; ?>"></td>
				<td><?php echo "$" . $qty * $book['Price']; ?></td>
			</tr>
			<?php } ?>
		    <tr>
		    	<th>&nbsp;</th>
		    	<th>&nbsp;</th>
		    	<th><?php echo $_SESSION['total_items']; ?></th>
		    	<th><?php echo "$" . $_SESSION['total_price']; ?></th>
		    </tr>
	   	</table>
	   	<input type="submit" class="btn btn-primary" name="save_change" value="Save Changes">
	</form>
	<br/><br/>
	<a href="../online-book-store-project-in-php-master/checkout.php" class="btn btn-primary">Go To Checkout</a> 
	<a href="../online-book-store-project-in-php-master/books.php" class="btn btn-primary">Continue Shopping</a>
<?php
	} else {
		echo "<p class=\"text-warning\">Your cart is empty! Please make sure you add some books in it!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "../online-book-store-project-in-php-master/template/footer.php";
?>