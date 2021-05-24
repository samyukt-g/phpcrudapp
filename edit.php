<?php
require_once "pdo.php";
session_start();

// DIE STATEMENT
if (! isset($_SESSION['name'])) {
	die("ACCESS DENIED");
}
if (isset($_POST['cancel'])) {
	header( 'Location: index.php' );
	return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id'])){

	// DATA VALIDATION
	if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
		$_SESSION['error'] = 'All fields are required';
		header( 'Location: edit.php?autos_id=' . $_POST['autos_id'] );
		return;
	}
	if (! is_numeric($_POST['year'])) {
		$_SESSION['error'] = 'Year must be numeric';
		header( 'Location: edit.php?autos_id=' . $_POST['autos_id'] );
		return;
	}
	if (! is_numeric($_POST['mileage'])) {
		$_SESSION['error'] = 'Mileage must be numeric';
		header( 'Location: edit.php?autos_id=' . $_POST['autos_id'] );
		return;
	}

	$sql = "UPDATE autos SET make = :mk, model = :mo, year = :yr, mileage = :mi WHERE autos_id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':mk' => $_POST['make'],
		':mo' => $_POST['model'],
		':yr' => $_POST['year'],
		':mi' => $_POST['mileage'],
		':id' => $_POST['autos_id']));
	$_SESSION['success'] = 'Record edited';
	header( 'Location: index.php' );
	return;

}

// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Samyukt G- Edit.php</title>
</head>
<body>
	<h1>Editing Automobile</h1>
	<?php
		// Flash pattern
		if ( isset($_SESSION['error']) ) {
		    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		    unset($_SESSION['error']);
		}
		$mk = htmlentities($row['make']);
		$mo = htmlentities($row['model']);
		$yr = htmlentities($row['year']);
		$mi = htmlentities($row['mileage']);
		$id = $row['autos_id'];
	?>
	<form method="post">
		<p>Make: 
			<input type="text" name="make" value="<?= $mk ?>">
		</p>
		<p>Model: 
			<input type="text" name="model" value="<?= $mo ?>">
		</p>
		<p>Year: 
			<input type="text" name="year" value="<?= $yr ?>">
		</p>
		<p>Mileage: 
			<input type="text" name="mileage" value="<?= $mi ?>">
		</p>
		<input type="hidden" name="autos_id" value="<?= $id ?>">
		<p>
			<input type="submit" value="Save"/>
			<input type="submit" value="Cancel">
		</p>
	</form>
</body>
</html>