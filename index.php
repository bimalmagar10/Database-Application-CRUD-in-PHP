<?php 
  session_start();
  require_once "pdo.php";
  $stmt = $pdo->query("SELECT autos_id,make,model,year,mileage FROM autos");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Bimal Thapa Magar</title>
 	<link rel="stylesheet" href="">
 	<style>
 		.container {
 			background: #ddd;
 			border-radius: 10px;
 			box-shadow:2px 5px #000;
 			font-family: monospace;

 		}
 	</style>
 	<?php require_once "bootstrap.php"; ?>
 </head>
 <body style="background: #aaa;">
 	
   <div class="container">
   	  <h1>Welcome to the Automobiles Database</h1>
   	  <?php 
   	  if (isset($_SESSION['success'])){
         echo '<p style="color:green">'.$_SESSION['success'].'</p>';
         unset($_SESSION['success']);
   	  } 

   	  if (isset($_SESSION['error'])) {
   	  	  echo '<p style="color:red">'.$_SESSION['error'].'</p>';
          unset($_SESSION['error']);
   	  }

   	  	?>
   	  	
   	

   	  <?php 
   	  if (isset($_SESSION['name'])) {
   	  		if (sizeof($rows) > 0) {
   	  			echo "<table border='2' class='table table-striped'>";
                echo "<thead><tr>";
                echo "<th>Make</th>";
                echo "<th>Model</th>";
                echo "<th>Year</th>";
                echo "<th>Mileage</th>";
                echo "<th>Action</th>";
                echo "</tr></thead>";
                foreach ($rows as $row) {
                	echo "<tr><td>";
                    echo($row['make']);
                    echo("</td><td>");
                    echo($row['model']);
                    echo("</td><td>");
                    echo($row['year']);
                    echo("</td><td>");
                    echo($row['mileage']);
                    echo("</td><td>");
                    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / <a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                    echo("</td></tr>\n");
                }
                echo "</table>";
   	  		} else {
   	  			echo "No rows found";
   	  		}
   	  		   echo '<p><a href="add.php">Add New Entry</a></p>
                      <p><a href="logout.php">Logout</a></p>';
   	       } else {

   	       	    echo '<p><a href="login.php">Please log in</a></p> <p>Attempt to <a href="add.php">add data</a>&nbsp;without logging in.</p>';
   	       }

   	  ?>
   	  	
   	  
   	  
   </div>


 </body>
 </html>