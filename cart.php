<?php 
    session_start();
    // require_once('./inc/config.php');    
    // require_once('./inc/helpers.php');  
    require_once('includes/Database.php');
    $dbc = new DbConnect();

    if(isset($_GET['action'],$_GET['item']) && $_GET['action'] == 'remove')
    {
        unset($_SESSION['cart_items'][$_GET['item']]);
        header('location:cart.php');
        exit();
    }
	
	$pageTitle = 'Demo PHP Shopping cart - Add to cart using Session';
	$metaDesc = 'Demo PHP Shopping cart - Add to cart using Session';
	
    include('layouts/header.php');

    if(isset($_POST['ISBN'])){
        $booksql= "SELECT * FROM Book WHERE ISBN = '".$_POST['ISBN']."'";
        $bookresult = $dbc->query($booksql);
        $book = $bookresult[0];
        if(isset($_SESSION['cart_items']) && array_key_exists($_POST['ISBN'],$_SESSION['cart_items'])){
            $_SESSION['cart_items'][$_POST['ISBN']]['qty'] += 1;
        }else{
            $_SESSION['cart_items'][$_POST['ISBN']] = [
                "product_name" => $book['Title'],
                "product_img" => $book['Image'],
                "qty" => 1,
                "product_price" => $book['Price']
            ];
        }
    }
    if(isset($_GET['action']) && $_GET['action']=='clear'){
        unset($_SESSION['cart_items']);
    }
?>
<div class="row">
    <div class="col-md-12">
        <?php if(empty($_SESSION['cart_items'])){
            ?>
        <table class="table">
            <tr>
                <td>
                    <p>Your cart is empty</p>
                </td>
            </tr>
        </table>
        <?php }?>
        <?php if(isset($_SESSION['cart_items']) && count($_SESSION['cart_items']) > 0){?>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalCounter = 0;
                    $itemCounter = 0;
                    foreach($_SESSION['cart_items'] as $key => $item){

                    $imgUrl = 'assets/images/books/'.((strlen(trim($item['product_img']))!=0) ? trim($item['product_img']) : 'no-image.jpg');

                    $total = $item['product_price'] * $item['qty'];
                    $totalCounter+= $total;
                    $itemCounter+=$item['qty'];
                    ?>
                <tr>
                    <td>
                        <img src="<?php echo $imgUrl; ?>" class="rounded img-thumbnail mr-2"
                            style="width:60px;"><?php echo $item['product_name'];?>

                        <a href="cart.php?action=remove&item=<?php echo $key?>" class="text-danger">
                            <i class="bi bi-trash-fill"></i>
                        </a>

                    </td>
                    <td>
                        $<?php echo $item['product_price'];?>
                    </td>
                    <td>
                        <input type="number" name="" class="cart-qty-single" data-item-id="<?php echo $key?>"
                            value="<?php echo $item['qty'];?>" min="1" max="1000">
                    </td>
                    <td>
                        <?php echo $total;?>
                    </td>
                </tr>
                <?php }?>
                <tr class="border-top border-bottom">
                    <td><a href="cart.php?action=clear"><button class="btn btn-danger btn-sm" id="emptyCart">Clear Cart</button></a></td>
                    <td></td>
                    <td>
                        <strong>
                            <?php 
                                echo ($itemCounter==1)?$itemCounter.' item':$itemCounter.' items'; ?>
                        </strong>
                    </td>
                    <td><strong>$<?php echo $totalCounter;?></strong></td>
                </tr>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-11">
                <a href="checkout.php">
                    <button class="btn btn-primary btn-lg float-right">Checkout</button>
                </a>
            </div>
        </div>
        <br>
        <br>

        <?php }?>
    </div>
</div>
<?php include('layouts/footer.php');?>