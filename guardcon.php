<?php
require ('dbconn.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $operation = $_POST['operation'];

  if($operation === 'new'){
      $pass=$_POST["password"];
      $fname=$_POST["fname"];
      $lname=$_POST["lname"];
      $gage=$_POST["age"];
      $gaddress=$_POST["address"];


      $insertsql = "INSERT INTO guard (guardPass,guardFname, guardLname,guardAge, guardAddress,isActive) VALUES('$pass','$fname', '$lname', '$gage', '$gaddress', 1)";
      $insertsqlresult = $conn->query($insertsql);

      if ($insertsqlresult === TRUE) {

       $return["result"]= "success";
       $return["message"]="guard successfully added";

      } else {
        $return["result"]="error";
        $return["message"]="error in adding guard". $conn->error; 
      }
  }else if($operation === 'timein'){
    $bookid = $_POST["bookingid"];
    $cardnumber = $_POST["cardnumber"];
    $idtype = $_POST["idtype"];
    $idnum = $_POST["idNumber"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $curdate = date("Y-m-d");
    $curtime = date("h:i");

    $query="INSERT INTO visitors(cardnumber,idType,idNumber,dateVisited,timeIn,visitorFirstname,visitorLastname,BookingID) VALUES ($cardnumber,'$idtype',$idnum,'$curdate', '$curtime', '$fname', '$lname', $bookid)";

    $update = $conn->query($query);


    if($update === TRUE){
      $arrivedsql = "UPDATE booking SET status='arrived' WHERE bookingID=$bookid";
      if($conn->query($arrivedsql) === TRUE){
        $return['result'] = 'success';
      }else{
        $return['result'] = 'error';
        $return['message'] = $conn->error;  
      }
    }else{
      $return['result'] = 'error';
    }

    echo json_encode($return);
}
else if($operation === 'edit'){
    $number=$_POST['guardNumber'];
    $fname=$_POST['guardFname'];
    $lname=$_POST['guardLname'];
    $password=$_POST['guardPass'];
    $address=$_POST['guardAddress'];
    $age=$_POST['guardAge'];
    $updatequery = "UPDATE guard SET guardFname='$fname', guardLname='$lname', guardPass='$password', guardAddress='$address', guardAge=$age where guardNumber=$number";
   
    $upresult = $conn->query($updatequery);
    
    if($upresult === TRUE){
      echo "success";
    }else{
      echo "error in update";
    }
  }  

}else if($_SERVER['REQUEST_METHOD'] === 'GET'){
  $operation = $_GET['operation'];
  
  if($operation === 'delete'){
    $unames=$_GET["deleteguard"];
    $deleted=0; 
    $return['mame'] = $unames;
    if(!isset($unames) || $unames === '')
      header('Refresh: 5; URL= adminpage.php');

    $myArray = explode(',', $unames);
    
    foreach($myArray as $value){
      if ($value !== ''){
        $deletesql = "DELETE FROM guard WHERE guardNumber = '$value'";

        if($conn->query($deletesql) === TRUE){
          $deleted =1;
        }
      }
    }
    if ($deleted == 1){
      $return["result"]= "success";
      $return["message"]="guard successfully deleted";
    }else {
      $return["result"]="error";
      $return["message"]="error in deleting guard". $conn->error; 
    }

  }else if($operation === 'timeout'){
    $id = $_GET["id"];
    $curtime = date("h:i");
    $query="UPDATE visitors SET timeOut='$curtime' WHERE BookingID=$id";
    $update = $conn->query($query);

    if($update === TRUE){
      $return['result'] = 'success';
      header('Location: guardpage.php');
    }else{
      $return['result'] = 'error';
      $return['message'] = $conn->error;  
    }
  }
}
echo json_encode($return);
$conn-> close();

?>

