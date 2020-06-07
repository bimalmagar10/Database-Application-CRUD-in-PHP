<?php
session_start();

require_once "pdo.php";

if (isset($_POST['cancel'])) {
	header("Location:index.php");
}


if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
    && isset($_POST['mileage'])) {
    
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All values are required';
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    } else{

    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year,mileage=:mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_GET['autos_id'])
    );
    $_SESSION['success'] = 'Record updated';
    header('Location: index.php');
    return;
}

}
// Guardian: Make sure that user_id is present
	if (!isset($_GET['autos_id'])) {
	    $_SESSION['error'] = "Missing autos_id";
	    header('Location: index.php');
	    return;
	}





$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}

$mk = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bimal Thapa Magar</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body style="background: #aaa;">
<div class="container">
 <h1>Editing <?php echo $mk; ?></h1>
<?php 
   if (isset($_SESSION['error'])) {
    echo '<p style="color:red; margin:0px auto;">'.$_SESSION['error'] .'</p>';
    echo '<br>';
    unset($_SESSION['error']);
 }
 ?>
    <form method="POST">
    	<div class="form-group">
	    	<label for="make">Make:</label>
	        <input type="text" name="make" size="40" id="make" class="form-control" value="<?php echo $mk ?>"/>
        </div>
        <div class="form-group">
	        <label for="model">Model</label>
	        <input type="text" name="model" id="model"size="40" class="form-control" value="<?php echo $mo ?>"/>
        </div>
        <div class="form-group">
	        <label for="year">Year</label>
	        <input type="text" name="year" size="10" id="year" class=" form-control" value="<?php echo $yr ?>"/>
        </div>
         <div class="form-group">
	        <label for="mileage">Mileage</label>
	        <input type="text" name="mileage" id="mileage" size="10" class="form-control"value="<?php echo $mi ?>"/>
        </div>
        <input type="hidden" name="autos_id" value="<?= $autos_id;?>">
        <input type="submit" class="btn btn-default" value="Save">
       <a href="index.php" class="btn btn-default">Cancel</a>
    </form>
    <p>
</div>
</body>
</html>