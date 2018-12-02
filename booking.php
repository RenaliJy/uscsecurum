<?php

use PHPMailer\PHPMailer\PHPMailer;
require ('dbconn.php');
require ('phpmailer/vendor/autoload.php');

$recipient = "theaisleznaehr@gmail.com";


$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPDebug = 0;
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "securum.usc@gmail.com";
$mail->Password = "uscsecurum2018";
$mail->setFrom('securum.usc@gmail.com', 'Vice-President for Academic Affairs-University of San Carlos');
$mail->addReplyTo('securum.usc@gmail.com', 'Rena Li Jy');



session_start();
date_default_timezone_set('Asia/Singapore');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$operation=$_POST['operation'];
	if($operation === 'insert'){
		$userid=$_SESSION["id"];
		$orgname=$_POST["name"];
		$datevisit=$_POST["datevisit"];
		$eadd=$_POST["emailadd"];
		$dept=$_POST["department"];
		$noperson=$_POST["noofpersons"];
		$purpose=$_POST["purpose"];
		$contact=$_POST["contact"];

		$current = date("Y-m-d");

		$insertsql = "INSERT INTO booking (emailAddress,datevisit,contactNumber, status,purpose,departmentTo,noofPersons,bookername,comment) VALUES ('$eadd','$datevisit', $contact, 'new', '$purpose', $dept, $noperson,'$orgname','')";

		if ($conn->query($insertsql) === TRUE) {
		    $return["result"]="success";
		    $return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
		} else {
			$return["result"]="error";
			$return["message"]="error " . $conn->error;
			$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
		}
		
	}else if($operation === 'accept'){
		$bookId=$_POST['bookingId'];
		$recipient = $_POST['email'];
		$recipientName = $_POST['bookingId'];
		$mail->addAddress($recipient, $recipientName);
		$mail->Subject = 'Welcome to University of San Carlos '.$recipientName.'';

		$mail->Body = "Your request have been accepted. You can now proceed in visiting the premises of University of San Carlos. Thank you! ";
		
		if (!$mail->send()) {
		    $return["result"]="error";
			$return["message"]="Mailer Error: " . $mail->ErrorInfo;
			$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
		} else {
		    $approvedsql = "UPDATE booking SET status='approved' WHERE bookingID = $bookId";

			if($conn->query($approvedsql) === TRUE){
				$return["result"]="success";
				$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
			}else {
				$return["result"]="error";
				$return["message"]="error " . $conn->error;
				$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
			}
		}
	}else if($operation === 'reject'){
		$bookId=$_POST['bookingId'];
		$rejectreason=$_POST['rejectreason'];
		$recipient = $_POST['email'];
		$recipientName = $_POST['bookingId'];
		$mail->addAddress($recipient, $recipientName);
		$mail->Subject = 'Welcome to University of San Carlos '.$recipientName.'';
		
		$mail->Body= "Your request have been rejected for the reason/s of  " .$rejectreason. ".  Thank you!";

		if (!$mail->send()){
			$return["result"]="error";
			$return["message"]="Mailer Error: " . $mail->ErrorInfo;
			$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
		} else {
			$rejectsql = "UPDATE booking SET status='rejected' , comment='$rejectreason' WHERE bookingID = $bookId";

			if($conn->query($rejectsql) === TRUE){
				$return["result"]="success";
				$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
			}else {
				$return["result"]="error";
				$return["message"]="error " . $conn->error;
				$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
			}
		}
	}else if($operation === 'query'){
		$bookId=$_POST['bookingId'];
		$query=$_POST['query'];
		$recipient = $_POST['email'];
		$recipientName = $_POST['bookingId'];
		$mail->addAddress($recipient, $recipientName);
		$mail->Subject = 'Welcome to University of San Carlos '.$recipientName.'';

		$mail->Body="We would like to know more about your request. Specifically on  " .$query. ".  Thank you!";

		if (!$mail->send()){
			$return["result"]="error";
			$return["message"]="Mailer Error: " . $mail->ErrorInfo;
			$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
		} else {
			$rejectsql = "UPDATE booking SET status='pending' , comment='$query' WHERE bookingID = $bookId";

			if($conn->query($rejectsql) === TRUE){
				$return["result"]="success"; 
			    $return["urlreferrer"]=$_SERVER['HTTP_REFERER']; 
			    
			}else {
				$return["result"]="error";
				$return["message"]="error " . $conn->error;
				$return["urlreferrer"]=$_SERVER['HTTP_REFERER'];
			}
		}
	}
}else{
	$operation=$_GET['operation'];
	if($operation === 'refresh'){
		$query="SELECT b.emailAddress, b.bookingID, b.bookername, b.contactNumber, d.deptName , b.datevisit, b.noofPersons, b.purpose, b.comment FROM booking b Join department d ON d.departmentID=b.departmentTo WHERE status = 'new' ORDER BY b.bookingID DESC";
		$result= $conn->query($query);

		if(mysqli_num_rows($result) > 0){
			$results = array();
			$return["result"]="success";
			while($row=mysqli_fetch_assoc($result)){
				$arresult["bookingID"] = $row["bookingID"];
				$arresult["bookername"] = $row["bookername"];
				$arresult["contactNumber"] = $row["contactNumber"];
				$arresult["deptName"] = $row["deptName"];
				$arresult["datevisit"] = $row["datevisit"];
				$arresult["noofPersons"] = $row["noofPersons"];
				$arresult["purpose"] = $row["purpose"];
				$arresult["comment"] = $row["comment"];
				$arresult["emailAddress"] = $row["emailAddress"];

				array_push($results,$arresult);
			}
			$return["booking"] = $results;
		}else{
			$return["result"]="error";
			$return["message"]="No new booking";
		}
	}else if($operation === 'refreshapprove'){
		$query="SELECT DISTINCT b.bookingID, b.bookername,d.deptName,b.emailAddress, b.datevisit,b.noofPersons,v.timeIn,v.timeOut,v.deptin,v.deptout,b.purpose  FROM booking b  LEFT JOIN visitors v ON b.bookingID=v.BookingID Join department d ON d.departmentID=b.departmentTo WHERE b.status IN ('approved','arrived') ORDER BY bookingID DESC";
		$result= $conn->query($query);

		if(mysqli_num_rows($result) > 0){
			$results = array();
			$return["result"]="success";
			while($row=mysqli_fetch_assoc($result)){
				$arresult["bookingID"] = $row["bookingID"];
				$arresult["bookername"] = $row["bookername"];
				$arresult["deptName"] = $row["deptName"];
				$arresult["datevisit"] = $row["datevisit"];
				$arresult["noofPersons"] = $row["noofPersons"];
				$arresult["purpose"] = $row["purpose"];
				$arresult["timeIn"] = $row["timeIn"];
				$arresult["timeOut"] = $row["timeOut"];
				$arresult["deptin"] = $row["deptin"];
				$arresult["deptout"] = $row["deptout"];
				$arresult["emailAddress"] = $row["emailAddress"];

				array_push($results,$arresult);
			}
			$return["booking"] = $results;
		}else{
			$return["result"]="error";
			$return["message"]="No new booking";
		}
	}
}

echo json_encode($return);
$conn->close();
?>