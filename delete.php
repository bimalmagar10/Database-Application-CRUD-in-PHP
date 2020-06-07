<?php 
  session_start();

 require_once "pdo.php";

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

if ( ! isset($_GET['autos_id']) ) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT make FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}
 ?>
 <!DOCTYPE html>
<html>
<head>
    <title>Bimal Thapa Magar</title>
    <?php require_once "bootstrap.php"; ?>
    <style>
    	.container p {
    		border:1px solid #000;
    		border-radius: 10px;
    		font-family: 'Roboto',sans-serif;
    		font-weight: bold;
    		padding: 10px;
    		background: #ddd;
    		font-size: 20px;
    	}
    </style>
</head>
<body style="background: #a13003;">
<div class="container">
    <p>Confirm: Deleting <?php echo $row['make'].'!'; ?></p>
    <form method="post">
    	<input type="hidden" name="autos_id" value="<?php echo $_GET['autos_id'] ?>">
    	 <input type="submit" value="Delete"  class="btn btn-default" name="delete"> <a href="index.php" class="btn btn-default">Cancel</a>
    </form>
</div>
</body>
</html>
