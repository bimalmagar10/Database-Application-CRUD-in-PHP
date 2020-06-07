<?php 
 session_start();

 if (!isset($_SESSION['name'])) {
 	die('ACCESS DENIED');
 }
 
 require_once "pdo.php";

 if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])  && isset($_POST['model'])) {
 	echo "vayo";
	   if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
	   	    $_SESSION['error'] = "All values are required";
	   	    header("Location:add.php");
	   	    return;
	   } 

	   if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {

		     $_SESSION['error'] = "Mileage and Year must an integer";
		     header("Location: add.php");
		     return;

	   }
		  $sql = "INSERT INTO autos (make,model,year,mileage) VALUES (:mk,:mo,:yr,:mi)";

			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
		     ':mk' => htmlentities($_POST['make']),
		     ':mo' => htmlentities($_POST['model']),
		     ':yr' => htmlentities($_POST['year']),
		     ':mi' => htmlentities($_POST['mileage']),

		));
			   $_SESSION['success'] = "Record inserted";
		        header("Location: index.php");
		        return;
			
	}
 


 ?>


<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Bimal Thapa Magar Autos Database</title>
 	<link rel="stylesheet" href="">
 	<?php require_once 'bootstrap.php'; ?>
 </head>
 <body style="background: #aaa;">
 	<div class="container">
 		<h1>Tracking Autos for <?= $_SESSION['name'];?></h1>
 		<?php 
   			if (isset($_SESSION['error'])) {
   		       echo '<p style="color:red">'.$_SESSION['error'].'</p>';
   		       unset($_SESSION['error']);

   			}
 		 ?>
 		<form action="" method="POST">
 			<div class="form-group">
				<label for="make">Make:</label>
				<input type="text" name="make" class="form-control" id="make" size="60">
		    </div>
		    <div class="form-group">
				<label for="model">Model:</label>
				<input type="text" name="model" class="form-control" id="model" size="60">
		    </div>
		    <div class="form-group">
				<label for="year">Year:</label>
				<input type="text" name="year" class="form-control" id="year"><br>
			</div>
			<div class="form-group">
				<label for="mileage">Mileage:</label>
				<input type="text" name="mileage" class="form-control" id="mileage" />
		    </div>
			<input type="submit" class="btn btn-default" value="Add">
			<a href="index.php" class="btn btn-default">Cancel</a>
			

	</form>
 	</div>
 </body>
 </html>