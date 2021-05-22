<?php
session_start();
require_once('pdo.php');

if ( ! isset($_SESSION['name'])) { die('Not logged in'); }
if ( isset($_POST['cancel'])) { header('Location: view.php'); return; }

$name = $_SESSION['name'];

// PDO::PREPARE
$stmt = $pdo->prepare("INSERT INTO Autos (make, year, mileage) VALUES (:mk, :yr, :mlg)");

// FORM::VALIDATION
// if (empty($_POST['make'])) {
//   $failureMsg = 'Make is required';
// } else {
//   $make = $_POST['make'];
//   if (is_numeric($_POST['mileage']) && is_numeric($_POST['year'])){
//     $mile = $_POST['mileage'];
//     $year = $_POST['year'];
//     // PDO::EXECUTE
//     $stmt->execute(array(
//         ':mk' => $make,
//         ':yr' => $year,
//         ':mlg' => $mile
//     ));
//     $failureMsg = false;
//     $successMsg = 'Record inserted';
//   } else {
//     $failureMsg = 'Mileage and year must be numeric';
//   }
// }
if (isset($_POST['make'])) {
	if (empty($_POST['make'])) {
		$_SESSION['failure'] = "Make is required";
	} else {
		$make = $_POST['make'];
		if (is_numeric($_POST['mileage']) && is_numeric($_POST['year'])){
		    $mile = $_POST['mileage'];
		    $year = $_POST['year'];
		    
		    // PDO::EXECUTE
		    $stmt->execute(array(
		        ':mk' => $make,
		        ':yr' => $year,
		        ':mlg' => $mile
	
		    ));
		    $_SESSION['failure'] = false;
		    $_SESSION['success'] = "Record inserted";
		} else {
			$_SESSION['failure'] = 'Mileage and year must be numeric';
		}
	}
	header('Location: add.php');
	return;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Samyukt G - Add.php</title>
</head>
<body>
	<h1>Tracking autos for <?php echo $name; ?></h1>
	<?php
		if (isset($_SESSION['success'])) {
			unset($_POST);
			unset($_SESSION['failure']);
			header('Location: view.php');
			return;
		}
		if (isset($_SESSION['failure'])) {
			echo ('<p style="color:red">' . $_SESSION['failure'] . '</p>');
			unset($_SESSION['failure']);
			unset($_POST);
		}
	?>
	<form method="post">
        <label for="make">Make:&nbsp&nbsp&nbsp&nbsp</label>
        <input type="text" name="make">
        <br>
        <label for="year">Year:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </label>
        <input type="text" name="year">
        <br>
        <label for="mileage">Mileage: </label>
        <input type="text" name="mileage">
        <br>
        <input type="submit" name="add" value="Add">
        <input type="submit" name="cancel" value="Cancel">
      </form>
</body>
</html>