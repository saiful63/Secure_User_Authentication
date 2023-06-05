<?php
session_start();

if(!isset($_SESSION['loggedin'])){
	header('location:index.php');
}

require_once 'con.php';

$sec_username = $link->prepare('select id,email,password from users where username=?');
	$sec_username->bind_param('s', $_SESSION['name']);
	$sec_username->execute();
	$sec_username->store_result();
 	if($sec_username->num_rows>0){

		$sec_username->bind_result($id, $email, $password);
		
		$sec_username->fetch();
        $_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
		
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    
	<!--Custom css-->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
   
    <nav class="navtop">
			<div>
				<h1>Secure User Authentication</h1>
				<a href="edit.php">Edit Info</a>
				<a href="logout.php">Logout</a>
				
			</div>
	</nav>
		
			

        <div class="content">
			<h2>Profile Section</h2>
            
			
			<div>
				<p>You are viewing your information</p>
				
				<table>
					<tr>
						<td>Username:</td>
						<td><?php echo $_SESSION['name'] ?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?php echo $password ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $email ?></td>
					</tr>
				</table>
				
			</div>
		</div>

		
</body>
</html>