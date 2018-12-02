<?php
  
require ('../dbconn.php'); 

#$operation = $_GET["operation"];


$time = $_GET["time"];
$num = $_GET["cardnum"];


if(preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time)){
	$select = "SELECT * FROM visitors WHERE BookingID=$num AND deptin IS NULL";
	$selectresult = $conn->query($select);

	if(mysqli_num_rows($selectresult) > 0){
		$sql = "UPDATE visitors SET deptin='$time' WHERE BookingID=$num AND timeOut IS NULL";
	}else{
		$sql = "UPDATE visitors SET deptout='$time' WHERE BookingID=$num AND timeOut IS NULL";
	}

	$timeinresult = $conn->query($sql);

	if($timeinresult === TRUE){
		$result["message"] = $timeinresult;
		$result["time"] = $time;
		$result["cardnumber"] = $num;
		$result["sql"] = $sql;
	}else{
		$result["error"] = "Error in query";
		$result["time"] = $time;
		$result["cardnumber"] = $num;
		$result["sql"] = $sql;
	}
	http_response_code(200);
	echo json_encode($result); //convert $result array to json format
}else{
	$result["message"] = "Error Parsing Time";
	http_response_code(404);
	echo json_encode($result); //convert $result array to json format
}
?>