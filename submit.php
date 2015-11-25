<?php // You need to add server side validation and better error handling here
include 'GoogleSpeechToText.php';

$data = array();

if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

	$uploaddir = './uploads/';
	foreach($_FILES as $file)
	{
		$newFile = $uploaddir .basename($file['name']);
		if(move_uploaded_file($file['tmp_name'], $newFile))
		{
			$files[] = $uploaddir .$file['name'];
			$path_parts = pathinfo($newFile);
			$newFileName = $path_parts['filename'];
			$newFileName = $newFileName.'.flac';
			$command = "~/bin/ffmpeg -i ".$newFile." ./uploads/" .$newFileName;			
			shell_exec($command);

			$apiKey = 'AIzaSyCbBqke_xLXiUFZd8rPuJiGJA5mnhqPeSM';
			$speech = new GoogleSpeechToText($apiKey);
			$file = realpath('./uploads/'.$newFileName); // Full path to the file.
			$bitRate = 44100; // The bit rate of the file.
			$output = $speech->process($file, $bitRate, 'en-US');			
		}
		else
		{
		    $error = true;
		}
	}
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('command' =>$output);
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);

?>
