<?php  
require_once 'pdo.php';
session_start();

// DIE STATEMENT
if (! isset($_SESSION['name'])) {
	die("ACCESS DENIED");
}
if (isset($_POST['cancel'])) {
	header( 'Location: index.php' );
	return;
}

// DATA VALIDATION
if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
	if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage'])) {
		$_SESSION['error'] = 'All fields are required';
		header( 'Location: add.php' );
		return;
	}
	if (! is_numeric($_POST['year'])) {
		$_SESSION['error'] = 'Year must be numeric';
		header( 'Location: add.php' );
		return;
	}
	if (! is_numeric($_POST['mileage'])) {
		$_SESSION['error'] = 'Mileage must be numeric';
		header( 'Location: add.php' );
		return;
	}

	$sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :mo, :yr, :mi)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':mk' => $_POST['make'],
		':mo' => $_POST['model'],
		':yr' => $_POST['year'],
		':mi' => $_POST['mileage']));
	$_SESSION['success'] = 'Record added';
	header( 'Location: index.php' );
	return;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Samyukt G- Add.php</title>
</head>
<body>
	<h1>Tracking autos for <?= $_SESSION['name']?></h1>
	<?php  
		if ( isset($_SESSION['error']) ) {
		  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
		  unset($_SESSION['error']);
		}
	?>
	<form method="post">
		<p>Make: &nbsp&nbsp&nbsp&nbsp<input type="text" name="make" size="40"/></p>
		<p>Model: &nbsp&nbsp&nbsp<input type="text" name="model" size="40"/></p>
		<p>Year: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="year" size="40"/></p>
		<p>Mileage: <input type="text" name="mileage" size="40"/></p>
		<input type="submit" name='add' value="Add">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</body>
</html>