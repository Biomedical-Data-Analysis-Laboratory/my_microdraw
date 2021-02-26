<?php

$rootdir = "/anotacion";

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].$rootdir."/php/base.php";
$connection=mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die("MySQL Error 1: " . mysql_error());

if(isset($_GET["action"])) $action=$_GET;
if(isset($_POST["action"])) $action=$_POST;

switch($action["action"])
{
	case "save":
		save($action);
		break;
	case "load":
		load($action);
		break;
	case "load_last":
		loadLast($action);
		break;
	case "remote_address":
		remote_address();
		break;
	case "save_label":
		saveLabel($action);
		break;
	case "load_label":
		loadLabel($action);
}

function save($args)
{
	global $connection;
	global $dbname;
	global $rootdir;

	header("Access-Control-Allow-Origin: *");

	//file_put_contents('./test_microDraw.txt', serialize($args));

	$origin = json_decode($args['origin']);
	$slice = $origin->slice;
	$source = str_replace('images/', '', $origin->source);
	$user = (is_string($origin->user) == true) ? $origin->user : $origin->user->IP;
	$finished = (strcmp($args['finished'], 'true') == 0) ? 1 : 0;

	$value = json_decode($args['value']);
	$sliceName = str_replace($_SERVER['DOCUMENT_ROOT'].$rootdir.'/images/', '', $value->filename);
	$q="INSERT INTO ".$dbname.".keyvalue (myOrigin, myKey, myValue, mySlice, mySliceName, mySource, myUser, finished) VALUES('"
		.$args["origin"]."','"
		.$args["key"]."','"
		.mysqli_real_escape_string($connection,$args["value"])."',"
		.$slice.",'"
		.mysqli_real_escape_string($connection,$sliceName)."','"
		.mysqli_real_escape_string($connection,$source)."','"
		.mysqli_real_escape_string($connection,$user)."',"
		.mysqli_real_escape_string($connection,$finished).")";
		//die($q);
	$result = mysqli_query($connection,$q);

	header('Content-Type: application/json');
	if($result) {
		$response["result"]="success";
	} else {
		$response["result"]="error";
		$response["description"]=mysqli_error($connection);
	}
	echo json_encode($response);
}

function load($args)
{
	global $connection;
	global $dbname;
	$arr=array();

	header("Access-Control-Allow-Origin: *");

	$q="SELECT * FROM ".$dbname.".keyvalue WHERE "
		." myOrigin = '".$args["origin"]."' AND"
		." myKey = '".$args["key"]."'";
	$result = mysqli_query($connection,$q);

	while($row = mysqli_fetch_assoc($result)) {
		if($row["myValue"])
		{
			//$row["myValue"]=json_decode($row["myValue"]);
			array_push($arr,$row);
		}
	}

	header('Content-Type: application/text');
	echo json_encode($arr);

	mysqli_free_result($result);
}

function loadLast($args)
{
	global $connection;
	global $dbname;

	header("Access-Control-Allow-Origin: *");

	// copy annotations of 'user' to guest
	// echo '<pre>';
	// copy_user_annotations_to_guest('masales');
	// die();

	$q="SELECT * FROM ".$dbname.".keyvalue WHERE "
		." myOrigin = '".$args["origin"]."' AND"
		." myKey = '".$args["key"]."'"
		." ORDER BY myTimestamp DESC LIMIT 1";
	$result = mysqli_query($connection,$q);
	if(mysqli_num_rows($result)>0) {
		header('Content-Type: application/text');
		$row = mysqli_fetch_assoc($result);
		echo json_encode($row);
	}
	mysqli_free_result($result);

}

function remote_address()
{
	header("Access-Control-Allow-Origin: *");

	echo $_SERVER['REMOTE_ADDR'];
}


function saveLabel($args)
{
	global $connection;
	global $dbname;
	global $rootdir;

	header("Access-Control-Allow-Origin: *");

	$origin = json_decode($args['origin']);
	$slice = $origin->slice;
	$user = (is_string($origin->user) == true) ? $origin->user : $origin->user->IP;
	$label = $origin->label;
	$observation = $origin->observation;

	/*
		Primero comprubo si exite ya en la BD un registro con un usario y una slide igual
	*/
	$q_ask="SELECT 'UniqueID' FROM ".$dbname.".labelobservation WHERE MyUser LIKE '".$user."' AND MySliceName LIKE '".$slice."'";
	//echo ($q_ask.'<br>');
	$result = mysqli_query($connection,$q_ask);
	$fila =mysqli_fetch_row($result);

	/*
		Si no exite el registro se crea realizando una consulta Insert into
	*/
	if(empty($fila)){

		$q="INSERT INTO ".$dbname.".labelobservation (MyUser, MySliceName, Observation, Label) VALUES('"
			.$user."','"
			.$slice."','"
			.$observation."','"
			.$label."')";
			//die($q);*/
			$result = mysqli_query($connection,$q);

			header('Content-Type: application/json');
			if($result) {
				$response["result"]="success";
			} else {
				$response["result"]="error";
				$response["description"]=mysqli_error($connection);
			}
			echo json_encode($response);
	}
	/*
		Si exite se actualiza los campos label y observation
	*/
	else {

		$q="UPDATE " .$dbname.".labelobservation SET Observation='".$observation."', Label='".$label."' WHERE MyUser LIKE '".$user."' AND
		MySliceName='".$slice."'";

			$result = mysqli_query($connection,$q);

			header('Content-Type: application/json');
			if($result) {
				$response["result"]="success";
			} else {
				$response["result"]="error";
				$response["description"]=mysqli_error($connection);
			}
			echo json_encode($response);
		// code...
	}
}

function loadLabel($args)
{
	global $connection;
	global $dbname;
	global $rootdir;

	header("Access-Control-Allow-Origin: *");

	$origin = json_decode($args['origin']);
	$slice = $origin->slice;
	$user = (is_string($origin->user) == true) ? $origin->user : $origin->user->IP;

	$q="SELECT Observation, Label FROM ".$dbname.".labelobservation WHERE MyUser LIKE '".$user."' AND MySliceName LIKE '".$slice."'";

	$result = mysqli_query($connection,$q);
	//var_dump($result);

	if(mysqli_num_rows($result)>0) {
		header('Content-Type: application/text');
		$row = mysqli_fetch_assoc($result);
		echo json_encode($row);
	}
	mysqli_free_result($result);
// code...
}


// function copy_user_annotations_to_guest($user)
// {
// 	global $connection;
// 	global $dbname;
// 	$guest_annotations=array();

// 	// first retrieve "guest" annotations and save them in array
// 	$q="SELECT * FROM `KeyValue` WHERE `myTimestamp` "
// 	   ."IN (SELECT MAX(`myTimestamp`) FROM `KeyValue` "
// 	   ."WHERE `myUser`='guest' AND `finished`=1 "
// 	   ."GROUP BY `myOrigin`) AND `myUser`='guest' "
// 	   ."ORDER BY `UniqueID` ASC ";
// 	$result = mysqli_query($connection,$q);
// 	while($row = mysqli_fetch_assoc($result)) {
// 		$row_aux = $row;
// 		unset($row_aux['UniqueID'], $row_aux['myUser'], $row_aux["myOrigin"]);
// 		array_push($guest_annotations,$row_aux);
// 	}
// 	mysqli_free_result($result);

// 	// print_r($guest_annotations);
// 	// echo '<br><br>================================================================<br><br>';

// 	$q="SELECT * FROM `KeyValue` WHERE `myTimestamp` "
// 	   ."IN (SELECT MAX(`myTimestamp`) FROM `KeyValue` "
// 	   ."WHERE `myUser`='$user' AND `finished`=1 "
// 	   ."GROUP BY `myOrigin`) AND `myUser`='$user' "
// 	   ."ORDER BY `UniqueID` ASC ";
// 	$result = mysqli_query($connection,$q);

// 	while($row = mysqli_fetch_assoc($result)) {
// 		$row_aux = $row;
// 		unset($row_aux['UniqueID'], $row_aux['myUser'], $row_aux["myOrigin"]);
// 		if(in_array($row_aux, $guest_annotations)) {
// 			//print_r($row);
// 		}else{
// 			//echo '<strong>'.print_r($row,1).'</strong>';

// 			$q="INSERT INTO ".$dbname.".KeyValue (myTimestamp, myOrigin, "
// 			."myKey, myValue, mySlice, mySliceName, mySource, myUser, finished) "
// 			."VALUES('"
// 			.$row["myTimestamp"]."','"
// 			.str_replace($user, 'guest', $row["myOrigin"])."','"
// 			.$row["myKey"]."','"
// 			.$row["myValue"]."',"
// 			.$row["mySlice"].",'"
// 			.$row["mySliceName"]."','"
// 			.$row["mySource"]."','guest',1)";

// 			// echo($q.'<br>');

// 			$result_in = mysqli_query($connection,$q);

// 			// if($result_in) {
// 			// 	echo ' <strong>Inserted</strong><br>';
// 			// }else{
// 			//  	var_dump($result_in);
// 			// }

// 		}
// 	}
// 	mysqli_free_result($result);

// }

?>
