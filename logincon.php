<?php
require ('dbconn.php');
session_start();

$id=$_POST["id"];
$pword=$_POST["pword"];
$type=$_POST["type"];

if($type === 'user'){
  $selectsql= "SELECT userID, userName, userType FROM user WHERE userID='$id' AND userPassword='$pword'";
  $result= $conn->query($selectsql);

  if($result->num_rows > 0 ){
    $return["result"]="success";
    while($row=mysqli_fetch_assoc($result)){
      $_SESSION["id"]=$row['userID'];
      $_SESSION["name"]=$row['userName'];
      $_SESSION["utype"]=$row['userType'];
      $return["usertype"]=$row['userType'];
    }
  }else{ 
    $selectguardsql= "SELECT guardNumber, guardFname FROM guard WHERE guardNumber=$id AND guardPass='$pword' AND isActive=1";

    $guardresult=$conn->query($selectguardsql);
  
    if($guardresult->num_rows > 0 ){
      $return["result"]="success";
      while($row=mysqli_fetch_assoc($guardresult)){
        $_SESSION["id"]=$row['guardNumber'];
        $_SESSION["name"]=$row['guardFname'];
        $_SESSION["utype"] = 10;
        $return["usertype"]= $_SESSION["utype"];
      }
    }else{ 
      $return["result"]="error";
      $return["message"]="username/password of guard not found";
    }
  }
}


echo json_encode($return);
$conn-> close();
?>