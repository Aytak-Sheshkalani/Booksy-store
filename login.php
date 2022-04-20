<?php
// Aytak Sheshkalani Ghalibaf 8741242
// for admin
// Username:admin@admin.ca
// Password:123
// for user
// Username:user@user.ca
// Password:123
session_start();
$cssFiles = '
<link rel="stylesheet" href="assets/css/booklist.css" />
<link href="//cdn.muicss.com/mui-0.10.3/css/mui.min.css" rel="stylesheet" type="text/css" />
';
$jsFiles = '
<script src="//cdn.muicss.com/mui-0.10.3/js/mui.min.js"></script>
';
require_once('includes/header.php');
// here we have a login form
require_once('includes/Database.php');
$dbc=new DbConnect();
$error ="";
if(isset($_POST['username']) && isset($_POST['password'])){
    // get user from database  
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "SELECT `password`, `Type` FROM User WHERE Email = ? LIMIT 1";
    $params= [
        ["value"=> $_POST['username'],"type"=>"s"],
    ];
    
    $res = $dbc->query($query,$params);
    $pass = $res[0]['password'];
    $type = $res[0]['Type'];
    if(password_verify($_POST['password'], $pass)){
        if( $type == 1){
            $_SESSION['user'] = [ 'role' => 'admin', 'username' => $_POST['username'] ];
            header('Location: adminPanel.php');

        }else{
            $_SESSION['user'] = [ 'role' => 'user', 'username' => $_POST['username'] ];
            header('Location: booklist.php');
        }
        
    }else{
        $error = "Invalid username or password";
    }
}
?>
<!-- login form in html -->
<div style="display:flex; justify-content:center;">
    <form class="mui-form" method="post" action="login.php">
        <?php  if(strlen($error) > 0){?>
        <div class="mui-panel">
            <p><?php echo $error; ?></p>
        </div>
        <?php } ?>
        <legend>Login</legend>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="text" name="username" maxlength="300">
            <label>Username</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input type="password" name="password" maxlength="300">
            <label>Password</label>
        </div>
        <button type="submit" class="mui-btn mui-btn--raised">Login</button>
    </form>
</div>
<?php
require_once('includes/footer.php');
?>