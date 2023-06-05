<?php

require_once 'con.php';
session_start();


if(isset($_POST['login'])){
 	
    $sec_username = $link->prepare('select id,password from users where username=?');
	$sec_username->bind_param('s', $_POST['username']);
	$sec_username->execute();
	$sec_username->store_result();
 	if($sec_username->num_rows>0){

		$sec_username->bind_result($id, $password);
		
		$sec_username->fetch();

		if(password_verify($_POST['password'], $password)){
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			
			$_SESSION['id'] = $id;
			header('location:dashboard.php');
			
		}else {
		
		$pass_error = 'Incorrect password!';
	    }
	}else {
	
	$user_error = 'Incorrect username!';
   }
 	
 }

?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE-edge">

	<meta name="viewport" content="width=device-width">

	

	<title>User Login</title>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    
	<!--Custom css-->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
 <nav class="navtop">
			<div>
				<h1>Secure User Authentication</h1>
				<a href="index.php">Home</a>
				
			</div>
</nav>
<div class="login_contain">
	
 <div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 cnt">
	
		<form action=""method="post">

			<table class="table table-bordered" align="center">
				<h3>
					User Login
				</h3>

						
				<div class="form-group">
					<div class="">
						<input type="text" placeholder="Username"required="" class="form-control log_inp" name="username">		
					</div>

					<label class="error">
						<?php
						if(isset($user_error)){
						echo $user_error;
						}
						?>	
		 		    </label>
				</div>
				
				<div class="form-group">
					<div class="">
							<input type="password" placeholder="Password"required="" class="form-control log_inp" name="password">		
					</div>
					<label class="error">
						<?php
						if(isset($pass_error)){
						echo $pass_error;
						}
						?>	
		 		    </label>
				</div>
				
						

				<div>
					<input type="submit" name="login" value="Login" class="btn btn-primary">
				</div>
			</table>
	    </form>
	
	
</div>

<div class="col-md-3"></div>
</div>
</div>

</body>
</html>