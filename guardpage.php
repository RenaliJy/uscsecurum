<!DOCTYPE html>
<html> 
	<head>
		<link rel="stylesheet" href="css/maxcdn.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
	    <script src="js/ajax.googleapis.jquery.min.js"></script>
	    <script src="js/maxcdn.bootstrap.min.js"></script>
		<style> 
			.th {
   				padding: 10px;
    			text-align: left;
				border: 1px solid #cdcdcd;
			}
	    	.usertab {
			    font-size: 15px;
			}
			.h3{
  				font-size: 30px;
   				font-family: auto;
			}
			.request{
    			float: left;
			    margin-top: -25px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 135px;
			    font-size: 20px;
			    margin-left: 71px;
			}
			.timein{
    			float: left;
			    margin-top: -25px;
			    font-family: monospace;
			    border-radius: 6px;
			    padding: 12px 135px;
			    font-size: 20px;
			    margin-left: 71px;
			}
			.bookbutton{
				font-family: monospace;
			}
		</style>
	</head>
		<body>
			<center> <br> <br> <br>
			<img src="images/usctc.png" alt="USC LOGO">
			<div class = "bookingFOrm" style="background-color:#FFFFFF; padding-top:20px;color:black;border-radius:5px;margin-bottom: 20px;margin-top:15px;width: 75%">
				<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px">

			<?php
				require ('loginheader.php');
				require ('dbconn.php');
				if($_SESSION['utype'] != 10 ) {
				   header('Location: index.php');
				}

				$bookerid=$_SESSION["id"];

				date_default_timezone_set('Asia/Singapore');
				$currentdate= date("Y-m-d");

				$query="SELECT * FROM booking JOIN department ON booking.departmentTo=department.departmentId JOIN booker ON booker.id=booking.bookername 
				WHERE booker.id=$bookerid";
				$result=$conn->query($query);
				
				$bookerquery="SELECT DISTINCT b.bookingID, b.bookername,d.deptName,b.datevisit,b.noofPersons,v.timeIn,v.timeOut,v.deptin,v.deptout,b.purpose  FROM booking b  LEFT JOIN visitors v ON b.bookingID=v.BookingID Join department d ON d.departmentID=b.departmentTo WHERE b.status IN ('approved','arrived') ORDER BY bookingID DESC";
				$bookerresult=$conn->query($bookerquery);

		
				$deptquery="SELECT deptName, departmentId FROM department WHERE deptName != 'administration'";
				$deptresult=$conn->query($deptquery);
			?>
				
			</center> <br> <br> 
			<div class="container">
				<ul class="nav nav-tabs"> </ul>
				<div class="tab-content">
			<table class="usertab" id="approvedbookingtable" class="tab-pane fade in active">
				<thead>
		            <tr>
					    <th class='usertab'>Booking ID </th>
					    <th class='usertab'>Name </th>
					    <th class='usertab'>Date of Visit </th>
					    <th class='usertab'>Department </th>
					    <th class='usertab'>No. of Persons </th>
					    <th class='usertab'>Time In </th>
					    <th class='usertab'>Dept In </th>
					    <th class='usertab'>Dept Out </th>
					    <th class='usertab'>Time Out</th>
					</tr>
				</thead>
					<tbody>
					    <?php
					      	while($row=mysqli_fetch_assoc($bookerresult)){
					        	echo "<tr class='usertab'>";
					        	echo "<td class='usertab' id='bookingID'>".$row['bookingID']."</td>";
					        	echo "<td class='usertab' id='bookername'>".$row['bookername']."</td>";
					        	echo "<td class='usertab' id='datevisit'>".$row['datevisit']."</td>";
					        	echo "<td class='usertab' id='deptName'>".$row['deptName']."</td>";
					        	echo "<td class='usertab' id='numberofPersons'>".$row['noofPersons']."</td>";
					  
					        	if(!isset($row['timeIn']) || $row['timeIn'] === '' )
					        		echo "<td class='usertab' id='timein'><button type='button' id='timeinbtn' class='btn btn-success btn-md btn-' data-toggle='modal' data-id='".$row['bookingID']."' data-name='".$row['bookername']."'data-target='#visitormodal'>Time In</button></td>";
					        	else
					        		echo "<td class='usertab' id='timein'>".$row['timeIn']."</td>";

					        	if(!isset($row['deptin']) || $row['deptin'] === '' ){
					        		echo "<td class='usertab'></td>";
					        	}else{
					        		echo "<td class='usertab' id='deptin'>".$row['deptin']."</td>";
					        	}

					        	if(!isset($row['deptout']) || $row['deptout'] === '' ){
					        		echo "<td class='usertab'></td>";
					        	}else{
					        		echo "<td class='usertab' id='deptout'>".$row['deptout']."</td>";
					        	}

                                if ((!isset($row['timeOut']) || $row['timeOut'] === '') && (isset($row['timeIn']) || $row['timeIn'] !== ''))
                                    echo "<td class='usertab' id='timeoutbtn'><a href='guardcon.php?operation=timeout&id=" .$row['bookingID']."'  class='btn btn-primary btn-md btn-'>Time Out</a></td>";
                                else
                                    echo "<td class='usertab' id='timein'>".$row['timeOut']."</td>";
                                echo "</tr>";
					        }
					    ?>
					</tbody>
			</table> <br> <br>
			<div class="bookingbutton">
			<button type='button' class='booking btn btn-primary btn-lg bookbutton' data-toggle="modal" data-target="#booking">Request Here</button>
			</div> 
			</div> <br> <br> 

			<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 100%; width: 100%; z-index: -999999; position: fixed;">
			</div>


			<div id="booking" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <div class="h3">
				       		<center> <h3>Request Form</h3> </center>
				       	</div>
				      </div> 
				      <div class="modal-body">
				        <form action="booking.php" method="post" class="bookingInput"> 
                            <center> <input id="newname" class="booking" type="text" name="name" placeholder="Name of Booker:" required> </center> 
                            <center> <input id="newcontact" class="booking" type="number" min="1" step="1" name="contact" placeholder="Contact No:" maxlength="11" required> </center> 
                            <center> <input id="newemail" class="booking" type="email" name="emailadd" placeholder="Email Address:" required> </center> 
                            <center> <input id="newno" class="booking"  type="number" min="1" step="1"name="noofpersons" placeholder="Expected No of Persons:" min="1" max=""required> </center> 
                            <center> <input id="visitdate" class="booking" type="date" name="datevisit" placeholder="Date of Visit:" $mydate = "year-month-day hour:minutes:PM/AM", $conerted=strtotime ($mydate); echo date ("F,j,Y",$converted);
                            echo required> </center> 
                            <center> <select id="newdepartment" name="department" style="width:75%;height:50px;margin-top:2px; margin-bottom:
                            11px;border-radius: 8px; padding-left: 4px " placeholder="Department To:">

                                <?php
                                    while($row=mysqli_fetch_assoc($deptresult)){
                                        echo "<option value='".$row['departmentId']."'>".$row['deptName']."</option>";
                                    }
                                ?>

                            </select> </center>
                            <center> <textarea id="newpurpose" rows="5" cols="62" class="booking" name="purpose" placeholder="Purpose:" required></textarea> </center> 
                            <center> <input id="newoperation" type="text" name="operation" value="insert" style="visibility: hidden"> </center> <br> <br> 
                            <center> <input id="newbookingbtn" type="submit" class="btn btn-primary btn-lg request" value="Submit Request"> </center> <br> <br> <br> 
                        </form>
				      </div>
			  		</div>
			  	</div>
  			</div>

  			<div id="visitormodal" class="modal fade">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <div class="h3">
				        	<center> <h3>Time-In Form</h3> </center>
				        </div>
				      </div>
				      <div class="modal-body">
				        <form action="guardcon.php" method="post" class="bookingInput">
				        	<center> <input class="booking" id="modalbookingid" type="number" min="1" step="1" name="bookingid" readonly  required> </center>
				        	<center> <input class="booking" id="tincardnum" type="number" min="1" step="1" name="cardnumber" placeholder="Card Number" required> </center>
				        	<center> <input class="booking" id="tinidtype" type="text" name="idtype" placeholder="ID Type" required>
				        	<input class="booking" type="number" id="tinidnum" min="1" step="1" name="idNumber" placeholder="ID Number" required> </center>
							<center> <input class="booking" id="modalbookingfname" name="fname" placeholder="First Name" required></textarea> </center>
							<center> <input class="booking" id="modalname" name="lname" placeholder="Last Name" required></textarea> <center>
							<center> <input type="text" id="tinops" name="operation" value="timein" style="visibility: hidden"> </center> <br> <br> 
							<center> <input id="timeinsubmit" class="btn btn-success btn-lg timein" value="Submit Details"> </center> <br> <br> <br> 
						</form>
				      </div>
			  		</div>
			  	</div>
  			</div>


		</body>
		<script>
			$(document).on("click", "#timeinbtn", function () {
			     var myBookId = $(this).data('id');
			     var myBookName = $(this).data('name');
			     $("#modalbookingid").val(myBookId);
			     $("#modalbookingfname").val(myBookName);
			});

            $( document ).ready(function() {
            	$("#timeinsubmit").click(function(e){
		            var bookid = $("#modalbookingid").val();
		            var cardnum = $("#tincardnum").val();
		            var idtype = $("#tinidtype").val();
		            var idnum = $("#tinidnum").val();
		            var bookfname = $("#modalbookingfname").val();
		            var lname = $("#modalname").val();
		            var ops = $("#tinops").val();
		            
	                if(bookid !== '' && cardnum !== '' && idtype !== '' && idnum !== '' && bookfname !== '' && lname !== '' && ops !== ''){
	                    e.preventDefault();
	                    $.ajax({
	                        url: "guardcon.php",
	                        dataType:"json",
	                        data: { bookingid : bookid , cardnumber : cardnum , idtype : idtype , idNumber : idnum, fname : bookfname , lname : lname , operation : ops},
	                        method: "POST",
	                        success: function(data){
	                            if(data.result == 'success'){
	                                location.href="guardpage.php";
	                            }else{
	                                alert(data.message);
	                            }
	                        },
	                        error: function(data){
	                            alert("error" + JSON.stringify(data));
	                        }
	                	});
	           		}
				});
                var dtToday = new Date();

                var month = dtToday.getMonth() + 1;
                var day = dtToday.getDate();
                var year = dtToday.getFullYear();

                if(month < 10)
                    month = '0' + month.toString();
                if(day < 10)
                    day = '0' + day.toString();

                var minDate = year + '-' + month + '-' + day;
                $('#visitdate').attr('min', minDate);

                setInterval(getapprovebookings, 20000); 
            });
            $("#newbookingbtn").click(function(e){

                var newname = $("#newname").val();
                var newcontact = $("#newcontact").val();
                var newemail = $("#newemail").val();
                var newno = $("#newno").val();
                var visitdate = $("#visitdate").val();
                var newdepartment = $("#newdepartment").val();
                var newpurpose = $("#newpurpose").val();
                var newoperation = $("#newoperation").val();
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

                if($.trim(newname) != '' && $.trim(newcontact) != '' && $.trim(newemail) != '' && $.trim(newno) != '' && $.trim(visitdate) != '' && $.trim(newdepartment) != '' && $.trim(newpurpose) && testEmail.test(newemail)){
                    e.preventDefault();
                    $.ajax({
                        url: "booking.php",
                        dataType:"json",
                        data: { name : newname, datevisit : visitdate, emailadd : newemail, department : newdepartment, noofpersons : newno, purpose : newpurpose, contact : newcontact, operation: newoperation },
                        method: "POST",
                        success: function(res){
                        	console.log(res);
                            if(res.result == 'success'){

                                location.href=res.urlreferrer;
                            }
                        },
                        error: function(res){
                            console.log("error" + JSON.stringify(res));
                        }
                    });
                }
            });

            function getapprovebookings(){
	    		$.ajax({
                    url: "booking.php",
                    dataType:"json",
                    data: { operation : "refreshapprove" },
                    method: "GET",
                    success: function(data){
                    	$("#approvedbookingtable tr").not(function(){ return !!$(this).has('th').length; }).remove();
                        if(data.result == 'success'){
                        	$.each(data.booking,function(i,book){
                        		$("#approvedbookingtable tr:last").after("<tr>"+
                        			"<td class='usertab' id='bookingID'>"+book.bookingID+"</td>" +
                        			"<td class='usertab' id='bookername'>"+book.bookername+"</td>" +
                        			"<td class='usertab' id='datevisit'>"+book.datevisit+"</td>" +
                        			"<td class='usertab' id='deptName'>"+book.deptName+"</td>" +
                        			"<td class='usertab' id='numberofPersons'>"+book.noofPersons+"</td>" +
                        			(!book.timeIn ? "<td class='usertab' id='timein'><button type='button' id='timeinbtn' class='btn btn-success btn-md btn-' data-toggle='modal' data-id='"+book.bookingID+"' data-name='"+book.bookername+"'data-target='#visitormodal'>Time In</button></td>" : "<td class='usertab' id='timein'>"+book.timeIn+"</td>" ) +
                        			(!book.deptin && book.deptin !== null ? "<td class='usertab' id='deptin'>" +book.deptin+ "</td>" : "<td class='usertab'></td>" ) +
                        			(!book.deptout && book.deptout !== null? "<td class='usertab' id='deptout'>" +book.deptout+ "</td>" : "<td class='usertab'></td>" ) +
                        			(!book.timeIn ? "<td class='usertab'></td>" : !book.timeOut ? "<td class='usertab' id='timein'><a href='guardcon.php?operation=timeout&id="+book.bookingID+"'  class='btn btn-primary btn-md btn-'>Time Out</a></td>" :  "<td class='usertab' id='timein'>" + book.timeOut + "</td>" )
                        			+"<tr>");
                        	});
                        }
                    },
                    error: function(data){
                        alert("error" + JSON.stringify(data));
                    }
                });
	    	}
		</script>
</html>