<?php
require_once('includes/header.php');	
$showAlert = false;
$showError = false;
$exists=false;
	
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Include file which makes the
	// Database Connection.
	include 'dbcon.php';
	
	$email = prepare_string($dbc,$_POST["email"]);
	$password = prepare_string($dbc,$_POST["password"]);
	$cpassword = prepare_string($dbc,$_POST["cpassword"]);
	$firstname = prepare_string($dbc,$_POST["fname"]);
	$lastname = prepare_string($dbc,$_POST["lname"]);	
	$address = isset($_POST["address"])? prepare_string($dbc,$_POST["address"]):null;

	
	
	$sql = "Select * from User where email='$email'";
	
	$result = mysqli_query($dbc, $sql);
	
	$num = mysqli_num_rows($result);
	
	// This sql query is use to check if
	// the email is already present
	// or not in our Database
	if($num == 0) {
		if(($password == $cpassword) && $exists==false) {
	
			$hash = password_hash($password,
								PASSWORD_DEFAULT);
				
			
			// Password Hashing is used here.
			$sql="INSERT INTO User(`email`,`password`,`FirstName`,`LastName`,`address`, `Type`) VALUES('$email','$hash','$firstname','$lastname','$address',0)";
	
			$result = mysqli_query($dbc, $sql);
	
			if ($result) {
				$showAlert = true;
			}
		}
		else {
			$showError = "Passwords do not match";
		}	
	}// end if
	
if($num>0)
{
	$showError="Email not available";
}
	
}//end if
	
?>
	
<!doctype html>
	
<html lang="en">

<head>
	
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content=
		"width=device-width, initial-scale=1,
		shrink-to-fit=no">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href=
"https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
		integrity=
"sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
		crossorigin="anonymous">
</head>
	
<body>
	
<?php
	
	if($showAlert) {
	
		echo ' <div class="alert alert-success
			alert-dismissible fade show" role="alert">
	
			<strong>Success!</strong> Your account is
			now created and you can login.
			<button type="button" class="close"
				data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div> ';
	}
	
	if($showError) {
	
		echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
		<strong>Error!</strong> '. $showError.'
	
	<button type="button" class="close"
			data-dismiss="alert aria-label="Close">
			<span aria-hidden="true">×</span>
	</button>
	</div> ';
}
		
	if($exists) {
		echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
	
		<strong>Error!</strong> '. $exists.'
		<button type="button" class="close"
			data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div> ';
	}

?>
	
<div class="container my-4 ">
	
	<h1 class="text-center">Signup Here</h1>
	<form action="signup.php" method="post">
	
		<div class="form-group">
			<label for="email">email</label>
		<input type="email" class="form-control" id="email"
			name="email" aria-describedby="emailHelp" required>	
		</div>
	
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" class="form-control"
			id="password" name="password" required>
		</div>
	
		<div class="form-group">
			<label for="cpassword">Confirm Password</label>
			<input type="password" class="form-control"
				id="cpassword" name="cpassword" required>
	
			<small id="emailHelp" class="form-text text-muted">
			Make sure to type the same password
			</small>
		</div>	
		<div class="form-group">
			<label for="fname">First name</label>
		<input type="text" class="form-control" id="fname"
			name="fname" aria-describedby="emailHelp" required>	
		</div>
		<div class="form-group">
			<label for="lname">Last name</label>
		<input type="text" class="form-control" id="lname"
			name="lname" aria-describedby="emailHelp" required>	
		</div>
		<div class="form-group">
			<label for="address">Address</label>
		<input type="text" class="form-control" id="address"
			name="address" aria-describedby="emailHelp" required>	
		</div>
		<button type="submit" class="btn btn-primary">
		SignUp
		</button>
	</form>
</div>
	
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	
<script src="
https://code.jquery.com/jquery-3.5.1.slim.min.js"
	integrity="
sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
	crossorigin="anonymous">
</script>
	
<script src="
https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
	integrity=
"sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
	crossorigin="anonymous">
</script>
	
<script src="
https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
	integrity=
"sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
	crossorigin="anonymous">
</script>
<?php
require('includes/footer.php');
?>
