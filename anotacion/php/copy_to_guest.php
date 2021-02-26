<?php

$rootdir = "/anotacion";

error_reporting(E_ALL);
ini_set('display_errors', 'On');
include "base.php";

// user annotations being copied to guest
$user = 'masales';

function copy_user_annotations_to_guest($user)
{
	global $connection;
	global $dbname;
	$guest_annotations=array();

	// first delete "guest" annotations and save them in array
	$q="DELETE FROM `keyvalue` WHERE `myUser`='guest'";
	$result = mysqli_query($connection,$q);
	// if($result == 1) {
	// 	echo 'Deleted properly<br><pre>';
	// }

	// then insert '$user' annotations to  guest annotations if not present yet
	$q="SELECT * FROM `keyvalue` WHERE `myTimestamp` "
	   ."IN (SELECT MAX(`myTimestamp`) FROM `keyvalue` "
	   ."WHERE `myUser`='$user' AND `finished`=1 "
	   ."GROUP BY `myOrigin`) AND `myUser`='$user' "
	   ."ORDER BY `UniqueID` ASC ";
	$result = mysqli_query($connection,$q);
	

	while($row = mysqli_fetch_assoc($result)) {
		// $row_aux = $row;
		// unset($row_aux['UniqueID'], $row_aux['myUser'], $row_aux["myOrigin"]);
		// if(in_array($row_aux, $guest_annotations)) {
		// 	//print_r($row);
		// }else{
		// 	//echo '<strong>'.print_r($row,1).'</strong>';

			$q="INSERT INTO ".$dbname.".keyvalue (myTimestamp, myOrigin, "
			."myKey, myValue, mySlice, mySliceName, mySource, myUser, finished) "
			."VALUES('"
			.$row["myTimestamp"]."','"
			.str_replace($user, 'guest', $row["myOrigin"])."','"
			.$row["myKey"]."','"
			.$row["myValue"]."',"
			.$row["mySlice"].",'"
			.$row["mySliceName"]."','"
			.$row["mySource"]."','guest',1)";
			
			// echo($q.'<br>');
			
			$result_in = mysqli_query($connection,$q);
			// print_r($row);
			
			// if($result_in) {
			// 	echo ' <strong>Inserted</strong><br>';
			// }else{
			//  	var_dump($result_in);
			// }

		// }
	}
	mysqli_free_result($result);

}

$connection=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die("MySQL Error 1: " . mysql_error());
copy_user_annotations_to_guest($user);

?>
