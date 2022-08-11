<?php
	//include condb to connect to the database
	include_once('condb.php');
	
	//select everything from table
	$sql = "SELECT * FROM `hemma`";
	
	$get_data_query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		
		if(mysqli_num_rows($get_data_query)!=0){
		$result = array();
		
		//fetch the data and save them in array
		while($r = mysqli_fetch_array($get_data_query)){
			extract($r);
			$result[] = array("id" => $id, "temperature" => $temperature, 'humidity' => $humidity, 'date' => $date);
		}
		$json = array("status" => 1, "info" => $result);
	}
	else{
		$json = array("status" => 0, "error" => "Information not found!");
	}
@mysqli_close($conn);
// Set Content-type to JSON
header('Content-type: application/json');
echo json_encode($json);