<?PHP
	session_start();
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "Login.php";</script>';
	}
?>
ChangePassword form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$OldPass = trim($_POST['OPass']);
		$NewPass = trim($_POST['Npass']);
		$RNewPass = trim($_POST['RNpass']);
		if($NewPass == $RNewPass){
			$conn = oci_connect("system", "Codes0535", "//localhost/XE");
			if (!$conn) {
				$m = oci_error();
				echo $m['message'], "\n";
				exit;
			} 
			$query = "SELECT PASSWORD FROM DARK WHERE ID='".$_SESSION['ID']."' and password='$OldPass'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$query = "UPDATE DARK SET PASSWORD='$NewPass' WHERE ID='".$_SESSION['ID']."' and password='$OldPass'";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				//echo '<script>window.location = "MemberPage.php";</script>';
				echo "Success !! <a href='MemberPage.php'>MemberPage</a> ";
			}
			else{
				echo "OldPassword Wrong !!";
			}			
		}
		else{
			echo "ERROR !! NOT THE SAME BETWEEN NewPassword AND RE-NewPassword ";
		}
		oci_close($conn);
	};
	
?>

<form action='ChangePass.php' method='post'>
	OldPassword <br>
	<input name='OPass' type='password'><br>
	NewPassword<br>
	<input name='Npass' type='password'><br><br>
	RE-NewPassword<br>
	<input name='RNpass' type='password'><br><br>
	<input name='submit' type='submit' value='OK'>
</form>
