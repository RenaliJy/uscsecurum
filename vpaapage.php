<!DOCTYPE html>
<?php 

require ('dbconn.php');

$query="SELECT b.emailAddress,b.bookingID, b.bookername, b.contactNumber, d.deptName , b.datevisit, b.noofPersons, b.purpose, b.comment FROM booking b
Join department d
ON d.departmentID=b.departmentTo
WHERE status = 'new' ORDER BY b.bookingID DESC";
$result= $conn->query($query);

?>

<html>
	<head>
		<link rel="stylesheet" href="css/maxcdn.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
	    <script src="js/ajax.googleapis.jquery.min.js"></script>
	    <script src="js/maxcdn.bootstrap.min.js"></script>
	    <style>
	    	th.usertab {
			    font-size: 15px;
			}
			a.vpaabutton {
			    float: left;
			}
			.nav>li>a {
   				 position: relative;
    			 display: block;
    			 padding: 0.5px 2px;
			}

			@media print
			{
				body * { visibility: hidden; }
				#qrcodeprint { visibility: visible; }
			}
			.h3{
  				font-size: 30px;
   				font-family: auto;
			}
			.accept{
				float: left;
			    margin-top: -17px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 54px;
			    font-size: 20px;
			    margin-left: 170px;
			}
			.reject{
    			float: left;
			    margin-top: 4px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 130px;
			    font-size: 20px;
			    margin-left: 65px;
			}
			.query{
    			float: left;
			    margin-top: 4px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 137px;
			    font-size: 20px;
			    margin-left: 66px;
			}
			
		</style>
	</head>
		<body>
			<center> <br> <br> <br> 
			<img src="images/usctc.png" alt="USC LOGO">
			<div class = "bookingFOrm" style="background-color:#FFFFFF; padding-top:20px;color:black;border-radius:5px;margin-bottom: 20px;margin-top:15px;width: 75%">
			<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px">

			<?php
				require('loginheader.php');
				if($_SESSION['utype'] != 1 ) {
					header('Location: index.php');
				}
			?>

			<br> 
			<div class = "headerbutton">
				<a class="vpaabutton btn btn-warning btn-md" href="vpaapage.php">Home</a>
				<a class="vpaabutton btn btn-primary btn-md" href="acceptvpaa.php">Approved</a>
				<a class="vpaabutton btn btn-success btn-md" href="queryvpaa.php">Pending</a>
				<a class="vpaabutton btn btn-danger btn-md" href="rejectvpaa.php">Rejected</a>
				<a class="vpaabutton btn btn-info btn-md" data-toggle="modal" data-target="#qrcode" data-id="1">QR Code Generator</a>
			</div> <br> 

			<div id="qrcode" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				      	</div>
				      	<center> <br> 
				     	<div class="modal-body">
				      		<img id="qrcodeprint" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=0&choe=UTF-8"/>
				      		<input type="text" id="numberss">
				      		<button onclick="myFunction()">Print this page</button>
				      	</div>
			  			</div>
			  		</div>
  				</div>
  			</div> <br> <br>

			<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px"> NEW BOOKINGS </h3> <br> <br> 
			<div class="container"> 
				<ul class="nav nav-tabs">
					 <li class="active">
				</ul>
			<table class="usertab" id="newbookingtable">
				<thead>
		            <tr>
		                <th class='usertab'>Booking ID</th>
		                <th class='usertab'>Booker's Name </th>
		                <th class='usertab'>Date of Visit</th>
		                <th class='usertab'>No. of Persons</th>
		                <th class='usertab'>Department To</th>
		                <th class='usertab'>Purpose</th>
		                <th class='usertab'>Accept</th>
		                <th class='usertab'>Reject</th>
		                <th class='usertab'>Send Message</th>
		            </tr>
		        </thead>
			
			<?php 
				while($row=mysqli_fetch_assoc($result)){
					echo "<tbody>";
						echo "<td class='usertab'>".$row['bookingID']."</td>";
						echo "<td class='usertab'>".$row['bookername']."</td>";
						echo "<td class='usertab'>".$row['datevisit']."</td>";
						echo "<td class='usertab'>".$row['noofPersons']."</td>";
						echo "<td class='usertab'>".$row['deptName']."</td>";
						echo "<td class='usertab'>".$row['purpose']."</td>";
						echo "<td class='usertab'><input type='submit' class='btn btn-primary btn-md' id='accept-button' value='Accept' data-toggle='modal' data-target='#acceptmodal' data-email='".$row['emailAddress']."'data-id='".$row['bookingID']."'></td> ";
						echo "<td class='usertab'><input type='submit' class='btn btn-danger btn-md' id='reject-button' value='Decline' data-toggle='modal' data-target='#rejectmodal' data-email='".$row['emailAddress']."' data-id='".$row['bookingID']."'></td> ";
						echo "<td class='usertab'><input type='submit' class='btn btn-success btn-md' id='query-button' data-email='".$row['emailAddress']."' value='Send Query' data-toggle='modal' data-target='#querymodal' data-id='".$row['bookingID']."'> </td>";
					echo "</tbody>";	
				}
			?>

		 	</table>
			</center>
			<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 100%; width: 100%; z-index: -999999; position: fixed;">	
			</div>
			
			<div id="acceptmodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-body">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				      	<div class="h3">
				      		<center> <h3>Confirm Request</h3> </center>
				      	</div>
				      </div>
				      	<center> <h4>Continue accepting the request?</h4> </center>
				        <form action="booking.php" method="post" class="bookingInput">
				        	<input type="text" name="email" class="email" style="visibility: hidden">
					        <input type="text" name="operation" value="accept" style="visibility: hidden">
					        <input type="text" name="bookingId" id="acceptbookingid" style="visibility: hidden">
					    	<input id="acceptreqbtn" class="btn btn-primary btn-md accept" value="Accept Request"> <br> <br> <br> <br> 
					    </form>
			  		</div>
			  	</div>
  			</div>

  			<div id="rejectmodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				      	<center>
				      	<div class="h3">
				        	<h3>Reject Request</h3>
				      </div>
				      <div class="modal-body">
				        <form action="booking.php" method="post" class="bookingInput">
				        	<input id="rejectmail" type="text" name="email" class="email" style="visibility: hidden">
					        <input id="rejectops" type="text" name="operation" value="reject" style="visibility: hidden">
					        <input id="rejectbookingid" type="text" name="bookingId"  style="visibility: hidden">
					        <textarea id="rejectreasonfld" rows="5" cols="62" class="booking" type="text" name="rejectreason" placeholder="Reject Reason :" required></textarea>
					    	<input id="rejectreqbtn" type="submit" class="btn btn-danger btn-md reject" value="Submit Reason"> <br> <br> <br> <br> 
					    </form>
						</center>
				      </div>
			  		</div>
			  	</div>
  			</div>

  			<div id="querymodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <center>
				      	<div class="h3">
				        	<h3>Write Message Here</h3>
				      </div>
				      <div class="modal-body">
				        <form action="booking.php" method="post" class="bookingInput">
				        	<input id="queryemail" type="text" name="email" class="email" style="visibility: hidden">
					        <input id="queryops" type="text" name="operation" value="query" style="visibility: hidden">
					        <input type="text" name="bookingId" id="querybookingid" style="visibility: hidden">
					       	<textarea id="txtquery" rows="5" cols="62" class="booking" type="text" name="query" placeholder="Write your message here. This will send as the email body." required></textarea> <br>
					    	<input id="queryreqbtn" type="submit" class="btn btn-success btn-md query" value="Submit Query"> <br> <br> <br>  
					    </form>
				      </div>
			  		</div>
			  	</div>
  			</div>

		</body>

		<script type="text/javascript">
	    	$(document).ready(function(){
		       	$("#acceptmodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#acceptbookingid').val(id);
					$('.email').val(eaddress);
				});

		        $("#rejectmodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#rejectbookingid').val(id);
					$('.email').val(eaddress);
				});

		        $("#querymodal").on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					var eaddress = $(e.relatedTarget).data('email');
					$('#querybookingid').val(id);
					$('.email').val(eaddress);
				});

				$("#numberss").change(function(){
					console.log($(this).val());
					$("#qrcodeprint").attr("src","https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl="+$(this).val()+"&choe=UTF-8");
				});

				setInterval(getnewbookings, 20000);

				$("#acceptreqbtn").click(function(e){
					var email= $("input[name='email']").val();
					var operation= $("input[name='operation']").val();
					var bokId= $("input[name='bookingId']").val();
					if(email !== '' && operation !== '' && bokId !== ''){
						e.preventDefault();
						$.ajax({
		                    url: "booking.php",
		                    dataType:"json",
		                    method: "POST",
		                    data: { operation : operation, email : email, bookingId : bokId },
		                    success: function(data){
		                    	if(data.result == 'success'){
			                    	alert("Successful");
			                    	location.href=data.urlreferrer;
			                    }else{
			                    	alert(data.error);
			                    }
		                    },
		                    error: function(data){
		                    	alert("error" + JSON.stringify(data));
		                    }

		                });
					}
				});

				$("#rejectreqbtn").click(function(e){
					var email= $("#rejectmail").val();
					var operation= $("#rejectops").val();
					var bokId= $("#rejectbookingid").val();
					var rejreason= $("#rejectreasonfld").val();

					console.log(email + ":" + operation + " : " + bokId);

					if(email !== '' && operation !== '' && bokId !== '' && rejreason !== ''){
						e.preventDefault();
						$.ajax({
		                    url: "booking.php",
		                    dataType:"json",
		                    method: "POST",
		                    data: { operation : operation, email : email, bookingId : bokId , rejectreason : rejreason },
		                    success: function(data){
		                    	if(data.result == 'success'){
			                    	alert("Successful");
			                    	location.href=data.urlreferrer;
			                    }else{
			                    	alert(data.error);
			                    }
		                    },
		                    error: function(data){
		                    	alert("error" + JSON.stringify(data));
		                    }

		                });
					}
				});

				$("#queryreqbtn").click(function(e){
					var email= $("#queryemail").val();
					var operation= $("#queryops").val();
					var bokId= $("#querybookingid").val();
					var query= $("#txtquery").val();

					console.log(email + ":" + operation + " : " + bokId);
					if(email !== '' && operation !== '' && bokId !== ''){
						e.preventDefault();
						$.ajax({
		                    url: "booking.php",
		                    dataType:"json",
		                    method: "POST",
		                    data: { operation : operation, email : email, bookingId : bokId, query: query },
		                    success: function(data){
		                    	if(data.result == 'success'){
			                    	alert("Successful");
			                    	location.href=data.urlreferrer;
			                    }else{
			                    	alert(data.error);
			                    }
		                    },
		                    error: function(data){
		                    	alert("error" + JSON.stringify(data));
		                    }

		                });
					}
				});
	    	});

	    	function getnewbookings(){
	    		$.ajax({
                    url: "booking.php",
                    dataType:"json",
                    data: { operation : "refresh" },
                    method: "GET",
                    success: function(data){
                    	$("#newbookingtable tr").not(function(){ return !!$(this).has('th').length; }).remove();
                        if(data.result == 'success'){
                        	console.log(data);
                        	$.each(data.booking,function(i,book){
                        		$("#newbookingtable tr:last").after("<tr>"+
                        			"<td class='usertab'>"+book.bookingID+"</td>" +
                        			"<td class='usertab'>"+book.bookername+"</td>" +
                        			"<td class='usertab'>"+book.datevisit+"</td>" +
                        			"<td class='usertab'>"+book.noofPersons+"</td>" +
                        			"<td class='usertab'>"+book.deptName+"</td>" +
                        			"<td class='usertab'>"+book.purpose+"</td>" +
                        			"<td class='usertab'><input type='submit' class='btn btn-primary btn-md' id='accept-button' value='Accept' data-toggle='modal' data-target='#acceptmodal' data-email='"+book.emailAddress+"'data-id='"+book.bookingID+"'></td>" +
                        			"<td class='usertab'><input type='submit' class='btn btn-danger btn-md' id='reject-button' value='Decline' data-toggle='modal' data-target='#rejectmodal' data-email='"+book.emailAddress+"' data-id='"+book.bookingID+"'></td>" +
                        			"<td class='usertab'><input type='submit' class='btn btn-success btn-md' id='query-button' data-email='"+book.emailAddress+"' value='Send Query' data-toggle='modal' data-target='#querymodal' data-id='"+book.bookingID+"'> </td>"
                        			+"<tr>");
                        	});
                        }
                    },
                    error: function(data){
                        alert("error" + JSON.stringify(data));
                    }
                });
	    	}

	    	function myFunction() {
			    window.print();
			}


	    </script>
	    <link rel="stylesheet" type="text/css" href="css/uscbooking.css">
</html>