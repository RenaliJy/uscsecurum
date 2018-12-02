<!DOCTYPE html>
<?php
	require ('dbconn.php'); 

$operation=$_POST['operation'];
$bookingId=$_POST['bookingId'];
date_default_timezone_set('Asia/Singapore');

if($operation === 'timein'){
	$idType=$_POST["idType"];
	$fname=$_POST["fname"];
	$lname=$_POST["lname"];

	$time = date("G");
	$currentdate = date("Y-m-d");
	
	$readsql = "SELECT * FROM visitors WHERE bookingID = $bookingId LIMIT 1";
	$result= $conn->query($readsql);

	if($result->num_rows > 0 ){
		echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <center> <center> <img src='images/timein.PNG' width='50%' height='50%' </center></center> <br>"; 
	    header('Refresh: 3; URL= guardpage.php');

	}else{
		$insertsql = "INSERT INTO visitors (idType, dateVisited,timeIn,visitorFirstname,visitorLastname,bookingID) 
		VALUES ('$idType','$idNumber', '$currentdate', '$time', '$fname', '$lname', $bookingId)";

		if ($conn->query($insertsql) === TRUE) {
			$arrivedsql = "UPDATE booking SET status='arrived' WHERE bookingID=$bookingId";

			if($conn->query($arrivedsql) === TRUE){
			   	echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <center> <center> <img src='images/newvisitor.PNG' width='50%' height='50%' </center></center> <br>"; 
			}
		     	header('Refresh: 3; URL= guardpage.php'); 
		} else {
		    echo "Error: " . $conn->error; 
		    header('Refresh: 3; URL= guardpage.php');
		}
	}
}else if($operation === 'timeout'){
	$time = date("G");

	$readsql = "SELECT * FROM visitors WHERE bookingID = $bookingId LIMIT 1";

	$result= $conn->query($readsql);

	if($result->num_rows > 0 ){
		while($row=mysqli_fetch_assoc($result)){
			$visitorid = $row['visitorID'];
			$approvedsql = "UPDATE visitors SET timeOut='$time' WHERE visitorID=$visitorid";

			if($conn->query($approvedsql) === TRUE){
				$donesql = "UPDATE booking SET status='done' WHERE bookingID=$bookingId";

				if($conn->query($donesql) === TRUE){
					echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <center> <center> <img src='images/timein.PNG' width='50%' height='50%' </center></center> <br>"; 
			  	}
			   		header('Refresh: 3; URL= guardpage.php'); 
			}else {
				echo "Error: " . $conn->error;
				header('Refresh: 3; URL= guardpage.php');
			}
		}
	}else{
		echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <center> <center> <img src='images/nottimroutvisitortimein.PNG' width='50%' height='50%' </center></center> <br>"; 
		header('Refresh: 3; URL= guardpage.php'); 
	}
}else{
	echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <center> <center> <img src='images/operationnotfound.PNG' width='50%' height='50%' </center></center> <br>"; 
	header('Refresh: 3; URL= guardpage.php');
}

$conn->close();

?>