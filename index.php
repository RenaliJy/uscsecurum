<!DOCTYPE html>
<html> 
	<head>
		<link rel="stylesheet" href="css/maxcdn.bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/uscbooking.css">
	    <script src="js/ajax.googleapis.jquery.min.js"></script>
	    <script src="js/maxcdn.bootstrap.min.js"></script>
	    
        <style>
	    	.loginlabel {
                float: left;
                margin-top: -25px;
                margin-left: 85px;
             }
    		.login-checkbox{
    			float:left;
	    		margin-top: -18px;
	    		margin-left: 80px;
    		}
            .login {
                float: left;
                margin-top: -25px;
                font-family: auto;
                border-radius: 6px;
                padding: 16px 65px;
                font-size: 20px;
                margin-left: 84px;
            }
	   	</style>

	</head>
		<body>
			<center> <br> <br> <br> <br>	  
			<div class = "bookingFOrm" style="background-color:#FFFFFF;padding-top:20px;color:grey;border-radius:5px;margin-bottom: 20px;margin-top:15px;width: 50%; padding: 50px"; >
				<h3 style="font-family: Century; margin-bottom:20px; margin-top: 5px"> <img src="images/uscusc.png" alt="USC LOGO"> <br> </h3> <br> <br> <br> 
				<form action="logincon.php" method="post">
                    <input class="booking" type="number" min="1" step="1"id="empid" name="id" placeholder="Employee ID:" required>
                    <input class="booking" type="password" id="empass" name="pword" placeholder="Password:" required> <br> <br>
                    <div class="login-checkbox">
                        <label> <input type="checkbox" alignment="left" name="remember"> &nbsp; Remember Me </label>
                    </div> <br> <br> <br> <br>  
                    <input id="login" type="submit" class="btn btn-success btn-lg login" value="LOG IN">
                </form> <br> <br> <br> 
			</center>
			<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 100%; width: 100%; z-index: -999999; position: fixed;">
                <img src="images/backbackground.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 100%; height: 100%; max-height: none; max-width: none; z-index: -999999; left: 0px;">
            </div>  <br> <br> <br> <br> <br> 

		</body>

<script type="text/javascript">
    $( document ).ready(function() {
        $("#login").click(function(e){
            var empid = $("#empid").val();
            var emppass = $("#empass").val();
                if(empid !== '' && emppass !== ''){
                    e.preventDefault();
                    $.ajax({
                        url: "logincon.php",
                        dataType:"json",
                        data: { id : empid , pword : emppass , type : "user" },
                        method: "POST",
                        success: function(data){
                            if(data.result == 'success'){
                                if(data.usertype == '0')
                                    location.href="adminpage.php";
                                if(data.usertype == '1')
                                    location.href="vpaapage.php";
                                if(data.usertype == '2')
                                    location.href="deptpage.php";
                                if(data.usertype == '10')
                                    location.href="guardpage.php";
                            }else{
                                $("#empid").val('');
                                $("#empass").val('');
                                alert("Wrong Username/Password");
                            }
                        },
                        error: function(data){
                            alert("error" + JSON.stringify(data));
                        }
                });
            }

        });
    });
    </script>

</html>