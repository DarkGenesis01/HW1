<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "Codes0535", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$codes = $_POST['CODES'];
		if($codes == "KK24"){
			$query = "SELECT * FROM DARK WHERE username='$username' and password='$password'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			// Fetch each row in an associative array
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$_SESSION['ID'] = $row['ID'];
				$_SESSION['NAME'] = $row['NAME'];
				$_SESSION['SURNAME'] = $row['SURNAME'];
				echo '<script>window.location = "MemberPage.php";</script>';
			}
			else{
			echo "Login fail.";
		}
		}
		else{
			echo "CODES WRONG!!";
		}
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Password<br>
	<input name='password' type='password'><br>
	CODES KK24<br>
	<input name='CODES' type='input'><br><br>
	<input name='submit' type='submit' value='Login'>
</form>
