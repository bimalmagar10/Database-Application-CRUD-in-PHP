<?php 
  session_start();

  $salt = 'XyZzy12*_';
  $stored_salt = '1a52e17fa899cf40fb04cfc42e6352f1'; 


  if(isset($_POST['email']) && isset($_POST['pass'])) {
   	  if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
   	  	  $_SESSION['error'] = "User name and password are required";
   	  } elseif (! (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))) {
   	  	     	$_SESSION['error'] = "Email must have an at-sign (@)";
               header("Location: login.php");
               return;
   	  	       } else {
   	  	          $check = hash('md5',$salt.$_POST['pass']);

		           if ($check == $stored_salt) {
		  	       error_log("Login success ".$_POST['email']);
                $_SESSION['name'] = $_POST['email'];
                header("Location: index.php");
                return;
		      } else {
		  	       $_SESSION['error'] = "Incorrect password";
		  	       error_log("Login fail ".$_POST['email']." $check");
                header("Location: login.php");
                return;
		  }
   	  }
   	  
   }

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Bimal Thapa Magar</title>
 	<link rel="stylesheet" href="">
 	<style>
 		.container span {
 			padding: 10px;
 			border-radius: 10px;
 			border:1px solid #000;
 			background: #ddd;
 			color: #000;
 		}
 		.container form {
 			margin-bottom: 20px;
 		}
 	</style>
 	<?php require_once 'bootstrap.php'; ?>
 </head>
 <body>
 	<div class="container">
 		<h1>Please Log In</h1>
 		<?php 
             if (isset($_SESSION['error'])) {
             	echo '<p style = "color:red";>'.$_SESSION['error'].'</p>';
             	unset($_SESSION['error']);
             }
 		 ?>
 		<form action="" method="POST">
 			 <div class="form-group">
	 			 <label for="email">User Name:</label>
	 		     <input type="text" name="email" id="email" class="form-control">
 		     </div>
 		     <div class="form-group">
	 			 <label for="password">Password:</label>
	 			 <input type="text" name="pass" id="password" class="form-control">
 			 </div>

 			<input type="submit" value="Log In" class="btn btn-default">
 			<a href="index.php" class="btn btn-default">Cancel</a>
 		</form>
 		<span><b>For password hint:</b> You must know yourself  what you should do!</span>
 	<!-- For password hint one :type in a lettered server side web programming language followed by 123-->
 	</div>
 </body>
 </html>