<?php
require 'database.php';

if (! empty ( $_POST )) {
	// keep track validation errors
	$nameError = null;
	$emailError = null;
	$mobileError = null;
	
	// keep track post values
	$name = $_POST ['name'];
	$email = $_POST ['email'];
	$mobile = $_POST ['mobile'];
	
	// validate input
	$valid = true;
	if (empty ( $name )) {
		$nameError = 'Please enter Name';
		$valid = false;
	}
	
	if (empty ( $email )) {
		$emailError = 'Please enter Email Address';
		$valid = false;
	} else if (! filter_var ( $email, FILTER_VALIDATE_EMAIL )) {
		$emailError = 'Please enter a valid Email Address';
		$valid = false;
	}
	
	if (empty ( $mobile )) {
		$mobileError = 'Please enter Mobile Number';
		$valid = false;
	}
	
	// insert data
	if ($valid) {
		$pdo = Database::connect ();
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare ( $sql );
		$q->execute ( array (
				$name,
				$email,
				$mobile 
		) );
		Database::disconnect ();
		header ( "Location: index.php" );
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/site.css" rel="stylesheet">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/photobooth.js"> </script>

<script type="text/javascript">


$( document ).ready(function() {
	$("#webcamresume").hide();
	 $('#webcam_snap').src = ' ';
		
	$("#webcamload").click(function() {
		$( '#webcam' ).photobooth();
	});


	//desctroy camera
	$("#webcamdestroy").click(function() {
		$('#webcam_snap').src = "images/img_avatar.png";
		$( '#webcam' ).data( "photobooth" ).destroy();
			console.log("Camera Destroyed");
	});

	$( '#webcam' ).photobooth().on( "image", function( event, dataUrl ){
		 // do stuff...
		 
// 			$( '#gallery' ).append( '<img src="' + dataUrl + '" >');
//		 $('#webcam_snap').src = dataUrl;
		 $('#webcam_snap').attr("src", dataUrl);

		 file = dataURLtoBlob(dataUrl);
	        var size = file.size;
	        alert("Picture size: " + size);
// 	        uploadImage(file);

	        
		 $.post('upload.php', dataUrl, function(returnedData) {
			    // do something here with the returnedData
			    console.log(returnedData);
			    alert(returnedData);
			});

		
				
// 			var img = $('<img id="dynamic">'); //Equivalent: $(document.createElement('img'))
// 			img.attr('src', dataUrl);
// 			img.appendTo('#gallery');
		
	});
	function uploadImage(file) {
	    var fd = new FormData();
	    // Append our Canvas image file to the form data
	    fd.append("files", file);
	    
	    // And send it
	    $.ajax({
	        url: "upload.php",
	        type: "POST",
	        data: fd,
	        processData: false,
	        contentType: false,
	        
	    }).done(function (result) {
	        alert("Received response..");
	        var resultObject = JSON.stringify(result);
	        alert(resultObject);
	    });
	}

	function dataURLtoBlob(dataUrl) {
	    // Decode the dataURL    
	    var binary = atob(dataUrl.split(',')[1]);
	 
	    // Create 8-bit unsigned array
	    var array = [];
	    for (var i = 0; i < binary.length; i++) {
	        array.push(binary.charCodeAt(i));
	    }
	 
	    // Return our Blob object
	    return new Blob([new Uint8Array(array)], {
	        type: 'image/png'
	    });
	}
	


	//pause camera
	$("#webcampause").click(function() {
		 // do stuff...
		$( '#webcam' ).data( "photobooth" ).pause();
		$("#webcamresume").show();
		$("#webcampause").hide();
	});
	$("#webcamresume").click(function() {
		 // do stuff...
		$( '#webcam' ).data( "photobooth" ).resume();
		$("#webcamresume").hide();
		$("#webcampause").show();
		$("#webcampause").resume();
	});

	
});

</script>
</head>

<body>

	<div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Create a Customer</h3>
			</div>
			
			<!-- Trigger the modal with a button -->
			<button type="button" class="btn btn-info btn-lg" data-toggle="modal"
				data-backdrop="static" data-keyboard="false" data-target="#myModal">Snap</button>

			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Customer Snap</h4>
						</div>
						<div class="modal-body">
							<table>
								<tbody>
									<tr>
										<td>
											<div id="webcam"></div>

										</td>
										<td><img id="webcam_snap" class="img-rounded img-responsive pull-right" 
											src='images/img_avatar.png' alt="Avatar"></td>
									</tr>
									<tr>
										<div>
										<span id="webcamload" class="btn btn-primary"> <i
											class="icon icon-2x icon-camera pull-left nomargin"></i>
										</span>
										<span id="webcampause" class="btn btn-primary"> <i
											class="icon icon-2x icon-pause pull-left nomargin"></i>
										</span>
										<span id="webcamresume" class="btn btn-primary"> <i
											class="icon icon-2x icon-play pull-left nomargin"></i>
											
										</span>
										</div>
									</tr>
								</tbody>
							</table>

						</div>
						<div class="modal-footer">
							<button id="webcamdestroy" type="button" class="btn btn-default"
								data-dismiss="modal">close</button>
						</div>
					</div>

				</div>
			</div>

			<form class="form-horizontal" action="create.php" method="post">
				<div
					class="control-group <?php echo !empty($nameError)?'error':'';?>
					">
					<label class="control-label">Name</label>
					<div class="controls">
						<input name="name" type="text" placeholder="Name"
							value="<?php echo !empty($name)?$name:'';?>">
						<?php if (!empty($nameError)): ?>
						<span class="help-inline"><?php echo $nameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				<div
					class="control-group <?php echo !empty($emailError)?'error':'';?>">
					<label class="control-label">Email Address</label>
					<div class="controls">
						<input name="email" type="text" placeholder="Email Address"
							value="<?php echo !empty($email)?$email:'';?>">
						<?php if (!empty($emailError)): ?>
						<span class="help-inline"><?php echo $emailError;?></span>
						<?php endif;?>
					</div>
				</div>
				<div
					class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					<label class="control-label">Mobile Number</label>
					<div class="controls">
						<input name="mobile" type="text" placeholder="Mobile Number"
							value="<?php echo !empty($mobile)?$mobile:'';?>">
						<?php if (!empty($mobileError)): ?>
						<span class="help-inline"><?php echo $mobileError;?></span>
						<?php endif;?>
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Create</button>
					<a class="btn" href="index.php">Back</a>
				</div>
			</form>
		</div>


	</div>
	<!-- /container -->
</body>
</html>
