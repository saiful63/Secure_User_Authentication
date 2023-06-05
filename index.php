<?php

require_once 'con.php';

session_start();

if(isset($_POST['registration']))
{


 
 $username=htmlspecialchars($_POST['username']);
 $email=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
 $validate_email=filter_var($email,FILTER_VALIDATE_EMAIL);
 $password=$_POST['password'];


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
	if($sec_email_check->num_rows==0 && $validate_email==true){
    $sec_username_check = $link->prepare('select id,username from users where username=?');
	$sec_username_check->bind_param('s', $username);
	$sec_username_check->execute();
	$sec_username_check->store_result();
     
    if($sec_username_check->num_rows==0){
         
         if(strlen($username)>7 && $username==true){
           

       if(strlen($password)>7){
    
     $password=password_hash($password, PASSWORD_DEFAULT);

     $query='INSERT INTO `users` (username, email, password) VALUES (?,?,?)';
    
    
    $ins_query = $link->prepare($query);
	$ins_query->bind_param('sss',$username,$email,$password);
	$ins_query->execute();
	$success = "You registered successfully";
    }else{
       	$password_l="Password must be more than 7 character.";
       }

         }else{
         	$username_l="Username must be More Than 7 character";
         }


    }else{
    	$username_error="This Username Already Exist";
    }

	}else{
		$email_error="This Email Address Already Exists or Invalid.";
	}
}

}
?>




<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE-edge">

	<meta name="viewport" content="width=device-width">

	

	<title>User Registration Form</title>

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
				<a href="login.php" id="login">Login</a>
				
			</div>
</nav>

<div class="container">
	
    
<div class="reg_contain">
	<label class="success">
		<h5>
		<?php
			if(isset($success)){
				echo $success;
			}
		?>
		</h5>
			
	</label>
	<div class="row">
		<div class="col-md-3"></div>
		 <div class="col-md-6">

			<h3>User Registration Form</h3>
	        <hr/>  

		 <form action=""method="POST" enctype="multipart/form-data" class="form-horizontal">
		   <div class="form-group">
		 	<label for="username" class="control-label">Username</label>	
		 	<div class="">
		 		<input type="text"  class="form-control"id="username" name="username" placeholder="Enter your Username"value="<?php if(isset($username)){echo $username;}?>">
		 	</div>
		 		<label class="error">
		 		<?php
                if(isset($input_error['username'])){
                 echo $input_error['username'];
                }
		 		?>	
		 		</label>


		 		<label class="error">
		 		<?php
                if(isset($username_error)){
                 echo $username_error;
                }
		 		?>	
		 		</label>

		 		<label class="error">
		 		<?php
                if(isset($username_l)){
                 echo $username_l;
                }
		 		?>	
		 		</label>
		 	</div>

            <div class="form-group">
		 	<label for="email" class="control-label">Email</label>	
		 	<div class="">
		 		<input type="text" name="email" class="form-control"id="email"placeholder="Enter your Email"value="<?php if(isset($email)){echo $email;}?>">
		 	</div>
		 		<label class="error">
		 		<?php
                if(isset($input_error['email'])){
                 echo $input_error['email'];
                }
		 		?>	
		 		</label>


		 		<label class="error">
		 		<?php
                if(isset($email_error)){
                 echo $email_error;
                }
		 		?>	
		 		</label>
		 	</div>


		 	<div class="form-group">
		 	<label for="password" class="control-label">Password</label>	
		 	<div class="">
		 		<input type="password"  class="form-control"id="password"name="password"placeholder="Enter your Password"value="">
		 	</div>
		 		<label class="error">
		 		<?php
                if(isset($input_error['password'])){
                 echo $input_error['password'];
                }
		 		?>	
		 		</label>



		 		<label class="error">
		 		<?php
                if(isset($password_l)){
                 echo $password_l;
                }
		 		?>	
		 		</label>
		 	</div>

            <div class="col-sm-4">
		 		<input type="submit" name="registration"value="Registration"class="btn btn-primary">
		 	</div>
		 </form>
		 <hr>
          

          <p>If you have account?Then please <a href="login.php">login</a></p>
	    </div>
		<div class="col-md-3"></div>
	</div>
</div>

</body>
</html>