<?php
session_start();

if(!isset($_SESSION['loggedin'])){
	header('location:index.php');
}

require_once 'con.php';

$sec_fetch = $link->prepare('select id,email,password from users where username=?');
	$sec_fetch->bind_param('s', $_SESSION['name']);
	$sec_fetch->execute();
	$sec_fetch->store_result();
 	if($sec_fetch->num_rows>0){

		$sec_fetch->bind_result($id, $email, $password);
		
		$sec_fetch->fetch();
    }

if(isset($_POST['edit'])){
 $username=htmlspecialchars($_POST['name']);
 $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
 $validate_email=filter_var($email,FILTER_VALIDATE_EMAIL);
 $password=$_POST['pass'];

$_SESSION['name'] = $username;
$_SESSION['email'] = $email;

$input_error=array();

if(empty($email)){
    $input_error['email']="The Email field is required.";
}

if(empty($username)){
    $input_error['username']="The Username field is required.";
}

if(empty($password)){
    $input_error['password']="The password field is required.";
}

if(count($input_error)==0){
	
	$sec_email_check = $link->prepare('select id,email from users where email=?');
	$sec_email_check->bind_param('s', $email);
	$sec_email_check->execute();
	$sec_email_check->store_result();
	if($sec_email_check->num_rows>=0 && $validate_email==true){
    $sec_username_check = $link->prepare('select id,username from users where username=?');
	$sec_username_check->bind_param('s', $username);
	$sec_username_check->execute();
	$sec_username_check->store_result();
    
    if($sec_username_check->num_rows>=0){
         
    if(strlen($username)>7 && $username==true){
           

    if(strlen($password)>7){

    $_SESSION['name'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    
     $password=password_hash($password, PASSWORD_DEFAULT);
     
     $query='update users set username = ?, email = ?, password = ? where id = ?';
    
    
    $update_query = $link->prepare($query);
	$update_query->bind_param('sssi',$username,$email,$password,$id);
	$update_query->execute();
	$update =  "Your information updated";


       }else{
       	
       }

         }else{
         	$username_l="Username must be More Than 7 character";
         }


    }else{
    	
    }

	}else{
		$email_error="Invalid Email.";
	}
}
 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Bootstrap-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    
	<!--Custom css-->
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
   
    <nav class="navtop">
			<div>
				<h1>Secure User Authentication</h1>
				<a href="dashboard.php"><i class="fas fa-user-circle"></i>Dashboard</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		
			

        <div class="content">
			<h2>Profile Section</h2>
            <div>
				<label class="success">
						<h5>
						<?php
							if(isset($update)){
								echo $update;
							}
						?>
						</h5>
				
				</label>
				<p>You can edit your information</p>
                <form action="" method="post">
                    <table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="name" value="<?php echo $_SESSION['name'] ?>"></td>
                        <td class="error">
							<h6>
							<?php
								if(isset($input_error['username'])){
									echo $input_error['username'];
								}
							?>
							</h6>

							<h6>
							<?php
								if(isset($username_l)){
									echo $username_l;
								}
							?>
							</h6>
				
				        </td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="text" name="pass" value="<?php echo $_SESSION['password'] ?>"></td>
						<td class="error">
							<h6>
							<?php
								if(isset($input_error['password'])){
									echo $input_error['password'];
								}
							?>
							</h6>

							<h6>
							<?php
								if(isset($password_l)){
									echo $password_l;
								}
							?>
							</h6>
				
				        </td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name="email" value="<?php echo $_SESSION['email'] ?>"></td>
					    <td class="error">
							<h6>
							<?php
								if(isset($input_error['email'])){
									echo $input_error['email'];
								}
							?>
							</h6>

							<h6>
							<?php
								if(isset($email_error)){
									echo $email_error;
								}
							?>
							</h6>
				
				        </td>
					</tr>
                    <tr>
                        <td>
                             <input type="submit" name="edit" value="Update" class="btn btn-primary">
                        </td>
                       
                    </tr>
				</table>
                </form>
				
			</div>
		</div>

		
</body>
</html>