<?php
require_once "pdo.php";
session_start();

// SELECT::AUTOS
$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");

// SELECT::EXISTS
$existsQuery = $pdo->query("SELECT EXISTS(SELECT 1 FROM autos) AS is_empty;");
$existsFetch = $existsQuery->fetch(PDO::FETCH_ASSOC);
$rows = false;
	// declares that the table is to be considered empty until mentioned otherwise
if ($existsFetch['is_empty'] == 1) { 
	$rows = true;
	// sets $rows to true if the table is NOT empty
} 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Samyukt G- Index.php</title>
</head>
<body>
	<h1>Welcome to the automobiles database</h1>
	<?php
		if( ! isset($_SESSION['name']) ) {
			echo('<p><a href="login.php">Please log in</a></p>');
			echo('<p>Attempt to go to <a href="add.php">add data</a> without logging in</p>');
		} else {
			// REDIR::RESPONSE
			if (isset($_SESSION['error'])) {
				echo '<p style="color:red>' . htmlentities($_SESSION['error']) . '</p>';
				unset($_SESSION['error']);
			}
			if (isset($_SESSION['success'])) {
				echo '<p style="color:green">' . htmlentities($_SESSION['success']) . '</p>';
				unset($_SESSION['success']);
			}
			
			// DETERMINE::OUTPUT
			if ($rows === false) {
				echo '<p>No rows found</p>';
				echo '<p><a href="add.php">Add New Entry</a></p>';
				echo '<p><a href="logout.php">Logout</a></p>';
			} else {
				echo '<table border="2">
						<thead>
							<tr>
								<th>Make</th>
								<th>Model</th>
								<th>Year</th>
								<th>Mileage</th>
								<th>Action</th>
							</tr>
						</thead><tbody>';
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr><td>';
					echo (htmlentities($row['make']));
					echo '</td><td>';
					echo (htmlentities($row['model']));
					echo '</td><td>';
					echo (htmlentities($row['year']));
					echo '</td><td>';
					echo (htmlentities($row['mileage']));
					echo '</td><td>';
				    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
				    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
				    echo("</td></tr>\n");

				}
				echo '</tbody></table>';
				echo '<p><a href="add.php">Add New Entry</a></p>
	<p><a href="logout.php">Logout</a></p>';
			}
			
		}
	?>
	
</body>
</html>