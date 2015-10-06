<?php
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit;
}

//echo getcwd();
$folder = getcwd().'uploads/';
//echo $folder;
$filename = md5($_SERVER['REMOTE_ADDR'].rand()).'.png';

// echo $filename;

$original = $folder.$filename;
echo $original;
//$original= "/home/sudeep/public_html/uploads/test.png";
// The JPEG snapshot is sent as raw input:
$input = file_get_contents('php://input');

if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	// Blank image. We don't need this one.
	exit;
}
$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $input));
$filename= "/home/sudeep/public_html/uploads/";
$result = file_put_contents($filename."test.png", $data);
//$result = file_put_contents("$original", $data);


//$result = file_put_contents($original, $input);
if (!$result) {
	echo '{
		"error"		: 1,
		"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
	}';
	exit;
}

 $info = getimagesize($original);
 echo $info;
 
if($info['mime'] != 'image/png'){
	unlink($original);
	exit;
}

// Moving the temporary file to the originals folder:
rename($original,'uploads/original/'.$filename);
$original = 'uploads/original/'.$filename;

// Using the GD library to resize
// the image into a thumbnail:

$origImage	= imagecreatefromjpeg($original);
$newImage	= imagecreatetruecolor(154,110);
imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370);

imagejpeg($newImage,'uploads/thumbs/'.$filename);

echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';
?>
