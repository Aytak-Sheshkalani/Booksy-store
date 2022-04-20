<?php
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
    $query = "SELECT * FROM User WHERE Email = ? and `Password` = ? and `Type`=1";
    $params= [
        ["value"=> $_POST['username'],"type"=>"s"],
        ["value"=> $password,"type"=>"s"]
    ];
    
    $res = $dbc->query($query,$params,false);
    if($res->affected_rows > 0){
        $_SESSION['user'] = ['user'=>$_POST['username'],'role'=>'admin'];
        header('Location: index.php');
    }else{
        $error = 'Invalid username or password';
    }
}
?>
<!-- login form in html -->
<div style="display:flex; justify-content:center;">
    <?php echo $error; ?>
    <form class="mui-form" method="post" action="login.php">
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