<!-- Aytak Sheshkalani Ghalibaf 8741242 -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title><?php 
    if(isset($pageTitle))
    {
        echo $pageTitle;
    }
    else
    {
        echo "Home";
    }
    ?></title>
	<meta name="description" content="<?php echo (isset($metaDesc)?$metaDesc:'Demo PHP Shopping Cart')?>">

    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/stylebody.css" />
    <?php
        if(isset($cssFiles)) echo $cssFiles;
    ?>
</head>

<body>
    <div class="search">
        <div class="logo"><img src="assets/images/Booksy-logo.png" /></div>
        <div>
            <form action="bookList.php" method="get">
                <input type="search" id="site-search" name="search" /><button>Search</button>
            </form>
        </div>
    </div>

    <div id="wrap">
        <div id="nav">
            <ul>
                <li><a href=".">HOME</a></li>
               
                <li><a href="store.php">STORE</a></li>
                <li><a href="bookList.php">BOOK LIST</a></li>
                <li><a href="login.php">LOGIN</a></li>
                <li><a href="signup.php">SIGN UP</a></li>
            </ul>
        </div>
    </div>