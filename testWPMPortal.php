<?PHP
// This file is meant to be called using Ajax from anywhere. It adds lines to a log file, so some injection attacks should be cleaned out...
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
?>

<?php 

	$bytes_written = 0;										//	Initialize our file write counter
	
	//str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )
	
	$myFile = $_POST["type"] . str_replace(" " , "", $_POST["bhCourseTitle"]). ".txt";								//	Define log file
	$fh = fopen($myFile, 'w');								//	Open the log for writing! (will overwrite previous information in file)
	if(flock($fh, LOCK_EX)) {								//	Lock the file to force exclusive write
		
		$stringData =  $_POST["JSONString"];				//	get the JSON string and write it to the file
		$bytes_written += fwrite($fh, $stringData);
		
		flock($fh, LOCK_UN); 								//	Now that we've written all the data we can unlock the file!
		fclose($fh);										//	... and close it.
		
		if($bytes_written > 0)								//	Now to let the client know what happened.
			echo '{"status":"success","bytes_written":"'.$bytes_written.'"}';
		else
			echo '{"status":"failure", "message":"Error:write failed!"}';
	} else {
		echo '{"status":"failure","message":"Error:file lock failed!"}';
	}
?>

	