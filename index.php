<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/site.css" rel="stylesheet">

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"> </script>
	
	
<script src="js/photobooth.js"> </script>

<script type="text/javascript">
$( document ).redy(function() {
	$( '#webcam' ).photobooth().data( "photobooth" ).resize( 400, 300 );
//	$( '#webcam' ).;
	
});

</script>
</head>

<body>
	<div class="container">
		<div class="row">
			<h3>Customer Maintenance</h3>
		</div>
		<div class="row">
			<p>
				<a href="create.php" class="btn btn-success">Create</a>
			</p>

			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email Address</th>
						<th>Mobile Number</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
                      <?php
																						include 'database.php';
																						$pdo = Database::connect ();
																						$sql = 'SELECT * FROM customers ORDER BY id DESC';
																						foreach ( $pdo->query ( $sql ) as $row ) {
																							echo '<tr>';
																							echo '<td>' . $row ['name'] . '</td>';
																							echo '<td>' . $row ['email'] . '</td>';
																							echo '<td>' . $row ['mobile'] . '</td>';
																							echo '<td width=250>';
																							echo '<a class="btn" href="read.php?id=' . $row ['id'] . '">Read</a>';
																							echo ' ';
																							echo '<a class="btn btn-success" href="update.php?id=' . $row ['id'] . '">Update</a>';
																							/* echo '<div class="btn btn-primary">
																							<i class="icon icon-2x icon-camera pull-left nomargin"></i>
																							<p>Take Snap</p>
																							</div>'; */
																							echo ' ';
																							echo '<a class="btn btn-danger" href="delete.php?id=' . $row ['id'] . '">Delete</a>';
																							echo '</td>';
																							echo '</tr>';
																						}
																						Database::disconnect ();
																						?>
                      </tbody>
			</table>
		</div>
	</div>
	<!-- /container -->
	
</body>
</html>
