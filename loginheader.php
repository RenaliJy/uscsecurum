<?php session_start(); 
if(!isset($_SESSION['name']) && empty($_SESSION['name'])) {
   header('Location: index.php');
}

?>
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