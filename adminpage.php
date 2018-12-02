<?php
	require ('adminheader.php');
	require ('dbconn.php');
	$query="SELECT u.userID,u.userName,u.userPassword, d.deptName,u.userPosition FROM user u JOIN department d ON d.departmentId = u.deptId WHERE u.userType <> 0";
	$result=$conn->query($query);


	$deptquery="SELECT d.deptName, d.departmentId,b.buildingId, b.buildingName, d.deptFloor, d.deptRoomNo FROM department d JOIN building b ON b.buildingId=d.deptBuilding";
	$deptresultmain=$conn->query($deptquery);

	$guardquery="SELECT guardPass, guardNumber,guardFname, guardLname, guardAge, guardAddress, isActive FROM guard";
	$guardresult=$conn->query($guardquery);
	
?>	

<!DOCTYPE html>
<html> 
	<head>
		<link rel="stylesheet" href="css/maxcdn.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
	    <script src="js/ajax.googleapis.jquery.min.js"></script>
	    <script src="js/maxcdn.bootstrap.min.js"></script>
		
		<style>
			.usertab {
			    font-size: 15px;
			}
	    	.label{
	    		color: gray;
    			font-size: 14px;
    			margin-left: 65px;
	    	}
	    	.modbtn{
    			float: left;
			    margin-top: -25px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 173px;
			    font-size: 20px;
			    margin-left: 71px;
			}
			.adddelbtn{
				font-family: auto;
			}

			.h3{
  				font-size: 30px;
   				font-family: auto;
			}

			.delete{
				margin-left:130px;
				padding: 12px 30px;
			}
	   	</style>

		<script type="text/javascript">
		    $(document).ready(function(){
		        $(".delete-row").click(function(){
		            $("table tbody").find('input[name="record"]').each(function(){
		            	if($(this).is(":checked")){
		                    $('#deleteuser').val($('#deleteuser').val() + "," + $(this).parent().siblings('#username').text());
		                }
		            });
		        });
		        $(".delete-dept").click(function(){
		            $("table tbody").find('input[name="buildingrecord"]').each(function(){
		            	if($(this).is(":checked")){
		                    $('#deletedepartment').val($('#deletedepartment').val() + "," + $(this).parent().siblings('#deptName').text());
		                }
		            });
		        });
		        $(".delete-guard").click(function(){
		            $("table tbody").find('input[name="guardrecord"]').each(function(){
		            	if($(this).is(":checked")){
		                    $('#deleteguard').val($('#deleteguard').val() + "," + $(this).parent().siblings('#guardNumber').text());
		                }
		            });
		        });
		        $("#updatemodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var name = $(e.relatedTarget).data('name');
					var password = $(e.relatedTarget).data('password');
					console.log(id + name + "" );
					$('#edituserId').val(id);
					$('#editusername').val(name);
					$('#edituserPassword').val(password);
				});
				$("#updatedept").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var name = $(e.relatedTarget).data('name');
					var floor = $(e.relatedTarget).data('floor');
					var room = $(e.relatedTarget).data('room');
					var building = $(e.relatedTarget).data('building');
					console.log(id + " " + name + " " + floor + " " + room );
					$('#editdeptid').val(id);
					$('#editdeptname').val(name);
					$('#editdeptfloor').val(parseInt(floor));
					$('#editdeptroomno').val(parseInt(room));
					$('#editbuilding').val(parseInt(building));
				});
				$("#updateguard").on('show.bs.modal',function(e){
					var number = $(e.relatedTarget).data('id');
					var fname = $(e.relatedTarget).data('fname');
					var lname = $(e.relatedTarget).data('lname');
					var password = $(e.relatedTarget).data('password');
					var address =$(e.relatedTarget).data('address');
					var age = $(e.relatedTarget).data('age');
					console.log( password + lname + "" + address + age);
					$('#editguardNumber').val(number);
					$('#editguardFname').val(fname);
					$('#editguardLname').val(lname);
					$('#editguardPass').val(password);
					$('#editguardAddress').val(address);
					$('#editguardAge').val(age);

				});

				$("#adduser").click(function(e){
					var hasSpace = /\s/g.test($('#uname').val());
					if(hasSpace){
						e.preventDefault();
						alert("Username must have one word");
					}else{
						var username = $('#uname').val();
						var pass = $('#password').val();
						var utype = $('#utype').val();
						var newuserdept = $('#newuserdept').val();
						var ops = $('#newuserops').val();

						if(username !== '' && pass !== '' && utype !== '' && newuserdept !== '' && ops !== ''){
							e.preventDefault();  //usercon.php
							$.ajax({
		                        url: "usercon.php",
		                        dataType: "json",
		                        data: { username : username , password : pass , usertype : utype , department : newuserdept , operation :  ops },
		                        method: "POST",
		                        success: function(data){
		                        	if(data.result === 'success'){
		                        		alert("Successfully added a user.")
		                        		location.href="adminpage.php";
		                        	}
		                        },
		                        error: function(data){
		                        	alert(JSON.stringify(data));
		                        }
		                    });
						}
					}
				})

				$("#deluserbtn").click(function(e){
					var deleteuser = $('#deleteuser').val();

					
					if(deleteuser !== ''){
						e.preventDefault();  //usercon.php
						$.ajax({
	                        url: "usercon.php",
	                        dataType: "json",
	                        data: { deleteus : deleteuser },
	                        method: "GET",
	                        success: function(data){
	                        	if(data.result === 'success'){
	                        		alert("Successfully deleted user/s.")
	                        		location.href="adminpage.php";
	                        	}
	                        },
	                        error: function(data){
	                        	alert(JSON.stringify(data));
	                        }
	                    });
					}
				})

				$("#newdeptbtn").click(function(e){
					var deptname = $('#ndepetname').val();
					var deptbuild = $('#ndeptbuild').val();
					var deptfloor = $('#ndeptfloor').val();
					var deptroom = $('#ndeptroomno').val();

					if(deptname !== '' && deptbuild !== '' && deptfloor !== '' && deptroom !== ''){
						e.preventDefault();  //deptcon.php
						$.ajax({
	                        url: "deptcon.php",
	                        dataType: "json",
	                        data: { deptname : deptname , building : deptbuild , floor : deptfloor , roomno : deptroom},
	                        method: "POST",
	                        success: function(data){
	                        	if(data.result === 'success'){
	                        		alert("Successfully added a department. ")
	                        		location.href="adminpage.php";
	                        	}
	                        },
	                        error: function(data){
	                        	alert(JSON.stringify(data));
	                        }
	                    });
					}
				})

				$("#deldeptbtn").click(function(e){
					var deletedept = $('#deletedepartment').val();
					
					if(deletedept !== ''){
						e.preventDefault();  //deptcon.php
						$.ajax({
	                        url: "deptcon.php",
	                        dataType: "json",
	                        data: { deletedept : deletedept },
	                        method: "GET",
	                        success: function(data){
	                        	if(data.result === 'success'){
	                        		alert("Successfully deleted department/s");
	                        		location.href="adminpage.php";
	                        	}
	                        	else{
	                        		alert(JSON.stringify(data));
	                        	}
	                        },
	                        error: function(data){
	                        	alert(JSON.stringify(data));
	                        }
	                    });
					}
				})


				$("#nguardbtn").click(function(e){
					var fname = $('#nguardfname').val();
					var lname = $('#nguardlname').val();
					var pass = $('#nguardpass').val();
					var address = $('#nguardaddress').val();
					var age = $('#nguardage').val();
					var ops = $('#nguardops').val();

					if(fname !== '' && lname !== '' && pass !== '' && address !== '' && age !== '' && ops !== ''){
						console.log("here");
						e.preventDefault();  //usercon.php
						$.ajax({
	                        url: "guardcon.php",
	                        dataType: "json",
	                        data: { fname : fname , lname : lname , password : pass , address : address , age :  age, operation:ops },
	                        method: "POST",
	                        success: function(data){
	                        	if(data.result === 'success'){
	                        		alert("Successfully added a guard. ")
	                        		location.href="adminpage.php";
	                        	}
	                        },
	                        error: function(data){
	                        	alert(JSON.stringify(data));
	                        }
	                    });
					}
				})

				$("#delguardbtn").click(function(e){
					var deletegrd = $('#deleteguard').val();
					var ops = $('#delguardops').val();
					
					if(deleteuser !== ''){
						e.preventDefault();  //usercon.php
						$.ajax({
	                        url: "guardcon.php",
	                        dataType: "json",
	                        data: { deleteguard : deletegrd, operation:ops },
	                        method: "GET",
	                        success: function(data){
	                        	if(data.result === 'success'){
	                        		alert("Successfully deleted guard/s.")
	                        		location.href="adminpage.php";
	                        	}else{
	                        		alert(JSON.stringify(data));
	                        	}
	                        },
	                        error: function(data){
	                        	alert(JSON.stringify(data));
	                        }
	                    });
					}
				})
		    });                                                                                                           
		</script>
		
	</head>
		<body>
			<center> <br> <br> <br>
			<img src="images/usctc.png" alt="USC LOGO">
			<div class = "bookingFOrm" style="background-color:#FFFFFF; padding-top:20px;color:black;border-radius:5px;margin-bottom: 20px;margin-top:15px;width: 75%">
			<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px">

			
			<div class="userheader">
				<table style="width:"100%;">
					<tr>
						<td width="200%; color:green;"><h2>Welcome, <?php  echo $_SESSION["name"] ?></h2></td>
						<form action="logout.php" method="post">
						
						<td width="200%">
							<input type="submit" class="btn btn-success btn-lg btn-" value="Logout">
						</td>
						</form>
					</tr>
				</table>
			</div>
			</center> <br>
			<div class="container">
				<ul class="nav nav-tabs">
				    <li class="active"><a data-toggle="tab" href="#home">User</a></li>
				    <li><a data-toggle="tab" href="#menu1">Department</a></li>
				    <li> <a data-toggle="tab" href="#menu2">Guard </a> </li>
				</ul> <br> <br>
				<div class="tab-content">
				    <div id="home" class="tab-pane fade in active">
				      	<table class="usertab">
					        <thead>
					            <tr>
					                <th>Select</th>
					                <th>Name</th>
					                <th>Department</th>
					                <th>Position</th>
					                <th></th>
					            </tr>
					        </thead>
					        	<tbody>
					        		<?php
					        			while($row=mysqli_fetch_assoc($result)){
					        				echo "<tr class='usertab'>";
					        				echo "<td class='usertab'><input type='checkbox' name='record'></td>";
					        				echo "<td class='usertab' id='username'>".$row['userName']."</td>";
					        				echo "<td class='usertab' id='department'>".$row['deptName']."</td>";
					        				echo "<td class='usertab' id='position'>".$row['userPosition']."</td>";
					        				echo "<td class='usertab'> <input type='submit' class='btn btn-success btn-md' id='update-button' value='Update' data-toggle='modal' data-target='#updatemodal' data-name='".$row['userName']."' data-id='".$row['userID']."' data-password='".$row['userPassword']."' </td>";
					        				echo "</tr>";
					        			}
					        		?>

					        	</tbody>
					    </table> <br> <br>

					    <div id="updatemodal" class="modal fade">
						  	<div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <div class="h3">
							       		<center> <h3>Edit Details</h3> <center> 
							       	</div>
							      </div> <br>
							      <div class="modal-body">
							        <form action="usercon.php" method="post" class="bookingInput">
								        <label class="label"> User ID</label> 
								        <center> <input class="booking" type="text" name="userid" id="edituserId" readonly> </center>  
								        <label class="label"> Username </label> 
								        <center> <input class="booking" type="text" name="username" id="editusername" value="accept"> </center> 
								        <label class="label"> Password </label> 
								        <center> <input class="booking" type="text" name="password" id="edituserPassword" placeholder="New Password"> </center> <br> <br>
								        <input type="text" name="operation" value="edit" style="visibility: hidden"> 
								    	<input type="submit" class="btn btn-success btn-lg modbtn" value="Submit   
								    	                                                     "> <br> <br> <br>  
								    </form>
							      </div>
						  		</div>
						  	</div>
			  			</div>
					    <button type='button' class='btn btn-primary btn-lg adddelbtn ' data-toggle="modal" data-target="#add"> Add User</button>
					    <button type="button" class="delete-row btn btn-danger btn-lg adddelbtn" data-toggle="modal" data-target="#delete">Delete User</button> <br> <br> <br> <br>
				    </div>

				    <div id="menu1" class="tab-pane fade">
				      	<table class="usertab">
					        <thead>
					            <tr>
					                <th>Select</th>
					                <th>Name</th>
					                <th>Building</th>
					                <th>Floor</th>
					                <th>Room No.</th>
					                <th></th>
					            </tr>
					        </thead>
					        	<tbody>
					        		<?php
					        			while($row=mysqli_fetch_assoc($deptresultmain)){
					        				echo "<tr class='usertab'>";
					        				echo "<td class='usertab'><input type='checkbox' name='buildingrecord'></td>";
					        				echo "<td class='usertab' id='deptName'>".$row['deptName']."</td>";
					        				echo "<td class='usertab' id='deptbuilding'>".$row['buildingName']."</td>";
					        				echo "<td class='usertab' id='deptfloor'>".$row['deptFloor']."</td>";
					        				echo "<td class='usertab' id='deptroomno'>".$row['deptRoomNo']."</td>";
					        				echo "<td class='usertab'><input type='submit' class='btn btn-success btn-md' id='update-button' value='Update' data-toggle='modal' data-target='#updatedept' data-name='".$row ['deptName']."' data-id='".$row ['departmentId']."' data-floor='".$row['deptFloor']."' data-room='".$row['deptRoomNo']."' data-building='".$row['buildingId']."'</td>";
					        				echo "</tr>";
					        			}
					        		?>
					       		</tbody>
					    </table> <br> <br>
					    <button type='button' class='btn btn-primary btn-lg adddelbtn' data-toggle="modal" data-target="#adddept"> Add Department</button>
					    <button type="button" class="delete-dept btn btn-danger btn-lg adddelbtn" data-toggle="modal" data-target="#deletedept">Delete Department</button> <br> <br> <br> <br>
					</div>

					<div id="updatedept" class="modal fade">
						  	<div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <div class="h3">
							       		<center> <h3>Edit Department</h3> </center>
							       	</div>
							      </div> <br>
							      <div class="modal-body">
							        <form action="deptcon.php" method="post" class="bookingInput">
							        	<label class="label"> Department ID </label> 
							        	<center> <input class="booking" type="text" name="deptid" id="editdeptid" readonly> </center> 
							        	<label class="label"> Department Name </label> 
								        <center> <input class="booking" type="text" name="deptname" id="editdeptname"> </center>
								        <label class="label"> Department Floor </label> 
								        <center> <input class="booking" type="number" name="deptfloor" id="editdeptfloor"> </center> 
								        <label class="label"> Department Room No.  </label> 
								        <center> <input class="booking" type="number" name="deptroomno" id="editdeptroomno"> </center>

								        <label class="label"> Department Building  </label> 
								        <center> 
								        <?php
							        		$buildqueries="SELECT buildingId, buildingName FROM building";
											$buildresults= $conn->query($buildqueries);
										echo "<select style='width:75%;height:50px;margin-top:2px; margin-bottom: 11px;border-radius: 8px; padding-left: 4px' name='building'>"	;
											while($deptrow=mysqli_fetch_assoc($buildresults)){
												echo "<option value='".$deptrow['buildingId']."'>".$deptrow['buildingName']."</option>";
											}
										echo "</select><br>";
							       		?>
							       		</center> <br> <br> 
								        <input type="text" name="operation" value="edit" style="visibility: hidden" readonly> 
								    	<input type="submit" class="btn btn-success btn-lg modbtn" value="Submit"> <br> <br> <br> 
								    </form>
							      </div>
						  		</div>
						  	</div>
			  			</div>

					<div id="menu2" class="tab-pane fade">
				      	<table class="usertab">
					        <thead>
					            <tr>
					                <th>Select</th>
					                <th>Id</th>
					                <th>First Name</th>
					                <th>Last Name</th>
					                <th>Status</th>
					                <th></th>
					            </tr>
					        </thead>
					        	<tbody>
					        		<?php
					        			while($row=mysqli_fetch_assoc($guardresult)){
					        				echo "<tr class='usertab'>";
					        				echo "<td class='usertab'><input type='checkbox' name='guardrecord'></td>";
					        				echo "<td class='usertab' id='guardNumber'>".$row['guardNumber']."</td>";
					        				echo "<td class='usertab' id='guardFname'>".$row['guardFname']."</td>";
					        				echo "<td class='usertab' id='guardLname'>".$row['guardLname']."</td>";
					        				echo "<td class='usertab' id='isActive'>".$row['isActive']."</td>";
					        				echo "<td class='usertab'><input type='submit' class='btn btn-success btn-md' id='update-button' value='Update' data-toggle='modal' data-target='#updateguard' data-fname='".$row ['guardFname']."' data-lname='".$row ['guardLname']."' data-id='".$row ['guardNumber']."' data-address='".$row['guardAddress']."' data-age='".$row['guardAge']."' data-status='".$row['isActive']."' data-password='".$row['guardPass']."'</td>";
					        				echo "</tr>";
					        			}
					        		?>
					       		</tbody>
					    </table> <br> <br>
					    <button type='button' class='btn btn-primary btn-lg adddelbtn' data-toggle="modal" data-target="#addguard"> Add Guard</button>
					    <button type="button" class="delete-guard btn btn-danger btn-lg adddelbtn" data-toggle="modal" data-target="#delguardmodal">Delete Guard</button> <br> <br> <br> <br>
					</div>

					<div id="updateguard" class="modal fade">
						  	<div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <div class="h3">
							       		<center> <h3>Edit Guard</h3> </center>
							       	</div>
							      </div> <br>
							      <div class="modal-body">
							        <form action="guardcon.php" method="post" class="bookingInput">
							        	<label class="label"> Guard Number </label> 
							        	<center> <input class="booking" type="number" name="guardNumber" id="editguardNumber" readonly> </center> 
							        	<label class="label"> Firstname </label> 
								        <center> <input class="booking" type="text" name="guardFname" id="editguardFname"> </center> 
								        <label class="label"> Lastname </label> 
								        <center> <input class="booking" type="text" name="guardLname" id="editguardLname"> </center> 
								        <label class="label"> Password  </label> 
								        <center> <input class="booking" type="text" name="guardPass" id="editguardPass" readonly> </center>
								        <label class="label"> Address  </label> 
								        <center> <input class="booking" type="text" name="guardAddress" id="editguardAddress"> </center>
								        <label class="label"> Age </label> 
								        <center> <input class="booking" type="number" name="guardAge" id="editguardAge"> </center><br> 
							       		<br> <br> 
								        <input type="text" name="operation" value="edit" style="visibility: hidden" readonly> 
								    	<input type="submit" class="btn btn-success btn-lg modbtn" value="Submit"> <br> <br> <br> 
								    </form>
							      </div>
						  		</div>
						  	</div>
			  			</div>
			  			
			<div id="add" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <div class="h3">
				       		<center> <h3>Add New User</h3> </center>
				       	</div>
				      </div>
				      <center> <br> 
				      <div class="modal-body">
				        <form action="usercon.php" method="post" class="bookingInput">
					        <input class="booking" type="text" id="uname" name="username" placeholder="Username" required><br>
					        <input class="booking" type="password" id="password" name="password" placeholder="Password" required><br>
					        <select class="booking" id="utype" style='width:75%;height:50px;margin-top:2px; margin-bottom: 11px;border-radius: 8px; padding-left: 4px' name="usertype">
					        	<option value="1">VPAA</option>
					        	<option value="2">SECRETARY</option>
					        </select> <br>
					        <?php
					        	$deptquery="SELECT deptName, departmentId FROM department";
								$deptresult= $conn->query($deptquery);

							echo "<select id='newuserdept' style='width:75%;height:50px;margin-top:2px; margin-bottom: 11px;border-radius: 8px; padding-left: 4px' name='department'>"	;
								while($deptrow=mysqli_fetch_assoc($deptresult)){
									echo "<option value='".$deptrow['departmentId']."'>".$deptrow['deptName']."</option>";
								}
							echo "</select><br>";
					        ?> <br> <br> 
					        <input id="newuserops" type="text" name="operation" value="add" style="visibility: hidden">
					        <input id="adduser" type="submit" class="add-row btn btn-primary btn-md modbtn" value="Add New"> <br> <br> <br> 
					    </form>
				      </div>
			  		</div>
			  	</div>
  			</div>

  			<div id="delete" class="modal fade">
			  	<div class="modal-dialog">
			   		<div class="modal-content">
			   			<div class="modal-header">
			     			<form action="usercon.php" method="get" class="bookingInput">
			     			<div class="h3">
			     				<center> <h3 class="deleteUser"> Delete User </h3> </center>
			     			</div>
				     		<div class="modal-body">
				        		<center> <h4> Are you sure you want to delete the selected user/s? </h4> <center>
				        		<input type="text" id="deleteuser" name="deleteus" style="visibility: hidden">
				      		</div>
					      		<input id="deluserbtn" type="submit" class="btn btn-danger delete" value="Delete">
					       		<button type="button" class="btn btn-info delete" data-dismiss="modal"> Cancel</button> <br> <br> <br> 
			      			</form>
			      		</div>
			    	</div>
			 	</div>
			</div>

			<div id="adddept" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				       		<button type="button" class="close" data-dismiss="modal">&times;</button>
				       		<div class="h3">
				       			<center> <h3>Add New Department</h3> </center>
				       		</div>
				      	</div>
				      	<center> <br> 
				     	<div class="modal-body">
				      		<form action="deptcon.php" method="post" class="bookingInput">
					       		<input class="booking" id="ndepetname" type="text" name="deptname" placeholder="Department Name" required><br>
					       		<?php
					        		$buildquery="SELECT buildingId, buildingName FROM building";
									$buildresult= $conn->query($buildquery);
								echo "<select id='ndeptbuild' style='width:75%;height:50px;margin-top:2px; margin-bottom: 11px;border-radius: 8px; padding-left: 4px' name='building'>"	;
									while($deptrow=mysqli_fetch_assoc($buildresult)){
										echo "<option value='".$deptrow['buildingId']."'>".$deptrow['buildingName']."</option>";
									}
								echo "</select><br>";
					       		?>
					       		<input class="booking"  id="ndeptfloor" type="number" name="floor" placeholder="Floor"  min="1" step="1" maxlength="2" required> <br> 
					       		<input class="booking"  id="ndeptroomno" type="number" name="roomno" placeholder="Room No"  min="1" step="1" maxlength="3" required> <br> <br> <br> 
					    		<input id="newdeptbtn" type="submit" class="add-row btn btn-primary btn-md modbtn" value="Add New"> <br> <br> <br> 
					    	</form>
				      	</div>
			  		</div>
			  	</div>
  			</div>

  			<div id="deletedept" class="modal fade">
			  	<div class="modal-dialog">
			   		<div class="modal-content">
			   			<div class="modal-header">
			     			<form action="deptcon.php" method="get" class="bookingInput">
				      		<div class="h3">
			     				<center> <h3 class="deletedept"> Delete Department </h3> </center>
			     			</div>
				      		<div class="modal-body">
				      		 	<center> <h4> Are you sure you want to delete the department/s? </h4> <center>
				        		<input type="text" id="deletedepartment" name="deletedept" style="visibility: hidden">
				     		</div>
				      			<input id="deldeptbtn" type="submit" class="btn btn-danger delete" value="Delete">
				        		<button type="button" class="btn btn-info delete" data-dismiss="modal">Close </button> <br> <br> 
			      			</form>
			      		</div>
			    	</div>
			  	</div>
			</div>

			<div id="addguard" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				       		<button type="button" class="close" data-dismiss="modal">&times;</button>
				       		<div class="h3">
				       			<center> <h3>Add New Guard</h3> </center>
				       		</div>
				      	</div>
				      	<center> <br> 
				     	<div class="modal-body">
				      		<form action="guardcon.php" method="post" class="bookingInput">
					       		<input id="nguardfname" class="booking"  type="text" name="fname" placeholder="First Name" required> <br> 
					       		<input id="nguardlname" class="booking"  type="text" name="lname" placeholder="Last Name" required> <br>
					       		<input id="nguardpass" class="booking" type="text" name="password" placeholder="Password" required><br>
					       		<input id="nguardaddress" class="booking"  type="address" name="address" placeholder="Address" required> <br>  
					       		<input id="nguardage" class="booking"  type="number" min="18" max="99" name="age" placeholder="Age" required> <br> <br> <br>
					       		<input id="nguardops" type="text" name="operation" value="new" style="visibility: hidden"> 
					    		<input id="nguardbtn" type="submit" class="add-row btn btn-primary btn-md modbtn" value="Add New"> <br> <br> <br> 
					    	</form>
				      	</div>
			  		</div>
			  	</div>
  			</div>

			<div id="delguardmodal" class="modal fade">
			  	<div class="modal-dialog">
			   		<div class="modal-content">
			   			<div class="modal-header">
			     			<form action="guardcon.php" method="get" class="bookingInput">
				      		<div class="h3"> 
				      			<center> <h3 class="deletedept"> Delete Guard</h3></center>
				      		</div>
				      			<div class="modal-body">
				      				<center> <h4> Are you sure you want to delete the selected guard/s? </h4> </center>
				        		<input type="text" id="deleteguard" name="deleteguard" style="visibility: hidden">
				        		<input id="delguardops" type="text" name="operation" value="delete" style="visibility: hidden">
				      			<input id="delguardbtn" type="submit" class="btn btn-danger delete" value="Delete">
				        		<button type="button" class="btn btn-info delete" data-dismiss="modal">Close</button>
				      			</div> <br> 
				      	</div>
			      			</form>
			    	</div>
			  	</div>
			</div>
		</body>

		<script type="text/javascript">
   		$( document ).ready(function() {
        $("#login").click(function(e){
            var uname = $("#uname").val();
            var password = $("#password").val();
            var utype = $("#utype").val();
                if(uname !== '' && password !== '' && utype){
                    e.preventDefault();
                    $.ajax({
                        url: "deptcon.php",
                        dataType:"json",
                        data: { id : uname , pword : password , type : utype },
                        method: "POST",
                        success: function(data){
                            if(data.result == 'success'){
                                if(data.usertype == '')
                                    location.href="deptpage.php";
                                if(data.usertype == '1')
                                    location.href="vpaapage.php";
                                if(data.usertype == '2')
                                    location.href="deptpage.php";
                            }else{
                                $("#uname").val('');
                                $("#password").val('');
                                $("#utype").val('');
                                alert("User not added");
                            }
                        },
                        error: function(data){
                            alert("error" + JSON.stringify(data));
                        }
                });
            }

        });


</html>