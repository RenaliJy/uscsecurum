<?php
  require ('dbconn.php'); 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['operation'])){
    $operation=$_POST['operation'];
    if($operation === 'edit'){
      $deptname=$_POST["deptname"];
      $deptbuilding=$_POST["building"];
      $deptfloor=$_POST["deptfloor"];
      $deptroomno=$_POST["deptroomno"];
      $deptid=$_POST["deptid"];

      $updatequery="UPDATE department SET deptName='$deptname',deptBuilding=$deptbuilding,deptFloor=$deptfloor,deptRoomNo=$deptroomno WHERE departmentId = $deptid ";
      $updateresult = $conn->query($updatequery);

      if($updateresult === TRUE)
        echo "success";
    }
  }else{
    $deptname=$_POST["deptname"];
    $deptbuilding=$_POST["building"];
    $deptfloor=$_POST["floor"];
    $deptroomno=$_POST["roomno"];

    $selectprev = "SELECT * FROM department";
    $prevcount = mysqli_num_rows($conn->query($selectprev));


    $insertsql = "INSERT INTO department (deptName,deptBuilding, deptFloor,deptRoomNo) 
    SELECT '$deptname','$deptbuilding', '$deptfloor', '$deptroomno' FROM dual WHERE NOT EXISTS (SELECT deptName FROM department WHERE deptName = '$deptname')";
    $insertsqlresult = $conn->query($insertsql);

    $selectcurrent = "SELECT * FROM department";
    $currentcount = mysqli_num_rows($conn->query($selectcurrent));

    if ($insertsqlresult === TRUE && $prevcount != $currentcount) {

      $return["result"]= "success";
      $return["message"]="dept successfully added";

    } else {
      $return["result"]="error";
      $return["message"]="error in adding department". $conn->error;  
    }
  }
}else if($_SERVER['REQUEST_METHOD'] === 'GET'){
  $unames=$_GET["deletedept"];
  $deleted=0;
  $return["unames"]= $unames;
  if(!isset($unames) || $unames === '')
    header('Refresh: 5; URL= adminpage.php');

  $myArray = explode(',', $unames);
  
  foreach($myArray as $value){
    if ($value !== ''){
      $deletesql = "DELETE FROM department WHERE deptName = '$value'";

      if($conn->query($deletesql) === TRUE){
        $deleted =1;
      }
    }
  }
  if ($deleted == 1){
    $return["result"]= "success";
    $return["message"]="dept successfully deleted";
  }
  else {
    $return["result"]="error";
    $return["message"]="error in deleting department". $conn->error;
  }
}
  
echo json_encode($return);
$conn->close();

?>