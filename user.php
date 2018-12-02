<!DOCTYPE html>

<?php 
	require ('dbconn.php');

	$query="SELECT deptName, departmentId FROM department WHERE deptName != 'administration'";
	$result= $conn->query($query);
?>

<html> 
	<head>
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
		<link rel='stylesheet' href='css/bootstrap.min.css'>
	</head>
		<body>
			<center> <br> <br> <br> 
				<img src="https://securum.000webhostapp.com/images/uscln.PNG" alt="USC LOGO"> <br> <br> <br> <br>
				<div class = "bookingFOrm" style="background-color:#ffffff2e;padding-top:20px;color:white;border-radius:5px;margin-bottom: 20px;margin-top:15px; width: 45%">
					<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px"> VISITORS FORM </h3> 
					<form action="booking.php" method="post" class="bookingInput">
						
						<input class="booking" type="text" name="orgname" placeholder="Name/Organization:" required><br> 
						<input class="booking" type="date" name="datevisit" placeholder="Date of Visit:" $mydate = "year-month-day hour:minutes:PM/AM", $conerted=strtotime ($mydate); echo date ("F,j,Y",$converted);
						echo required><br> 
						<input class="booking"  type="email" name="emailadd" placeholder="Email Address:" required><br>
						<input class="booking"  type="number" min="1" step="1"name="contact" placeholder="Contact No:" maxlength="11" required><br>
						<input class="booking"  type="number" min="1" step="1"name="noofpersons" placeholder="Expected No of Persons:" maxlength="2" required> <br> 	
						<select name="department" style="width:75%;height:50px;margin-top:2px; margin-bottom: 11px;border-radius: 8px; padding-left: 4px " placeholder="Department To:">			
							
							<?php 
								while($row=mysqli_fetch_assoc($result)){
									echo "<option value='".$row['departmentId']."'>".$row['deptName']."</option>";
								}
							?>	

						</select> <br>
						<textarea rows="5" cols="62" class="booking" name="purpose" placeholder="Purpose:" required></textarea><br>
						<input type="text" name="operation" value="insert" style="visibility: hidden"><br>	
						<input type="submit" class="btn btn-success btn-lg btn-" value="Submit">
					</form> 
			</center>
			<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 100%; width: 100%; z-index: -999999; position: fixed;">
				<img src="https://securum.000webhostapp.com/images/bodybackground.jpeg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 100%; height: 100%; max-height: none; max-width: none; z-index: -999999; left: 0px;"/>
			</div>
		</body>
</html>