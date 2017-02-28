<?php 
session_start();

	$user = $_POST['user'];
	$res="";
	$UEr="";
	$PEr="";
	$forgot="";
	$fok = 0;
	$p = "";
	include 'a1.lib';
if($_POST) {

				$user = $_POST['user'];

				$link = new DBLink();

 			if (isset($_POST['email'])) {
 				$mail = $_POST['mail'];
 				$sql_query = "SELECT * from users";
				$result = $link->query($sql_query);
					while($row = $result->fetch_assoc()){ 
						if ($user == $row['username']) {
 						$hint = $row['passwordHint'];
		 			}
		 		}

 				if (($hint !="") && ($mail !="")) {

 					$message ="Your user name is ".$user ." and your hint is ".$hint;  
 					$result = @mail("int322_151b14@localhost", "Retrive password", $message, "From Oleg");
				}
			$res ="The mail was sent to user: ".$user;
 			}


			if (!empty($_POST['forget'])) {
				if($_POST['user']==""){
					$p = "Please, provide the name";
				}
				else {
					$fok = 1;
					$forgot = "Please, write your email";
	 			}
	 		}


			elseif (($_POST['user']=="") || ($_POST['password']=="")){
				if ($_POST['user']=="")
					$UEr="Please provide user name";
				if ($_POST['password']=="")
					$PEr="Please provide password";
			}


			else {
				
				$password = crypt($_POST['password'], '$2a$09$anexamplestringforsalt$');
			/*	$lines = file('/home/int322_151b14/secret/topsecret');
				$dbserver = trim($lines[0]);
				$uid = trim($lines[1]);
				$pw = trim($lines[2]);
				$dbname = trim($lines[3]);

				$link = mysqli_connect($dbserver,$uid,$pw,$dbname) or die ('Could not connect: ' . mysqli_error($link));*/

				if($link) {
					$sql_query = "SELECT * from users";
					$result = $link->query($sql_query);

						while($row = $result->fetch_assoc()){
 							if (($user == $row['username']) && ($password == $row['password'])) {
 								$_SESSION['user'] = $user; 
 								$_SESSION['role'] = $row['role']; 
				 				header ("Location: view.php");
 							}

 						}$res="Combination username/password does not match";
				}
			}
}	

?>


<html>

<body align="center">
	<form method="post" action="">
		<table  align="center">
		<tr>
			<td align="center">Username</td><td align="left"><input name="user" type="text" value="<?php if (isset($_POST['user'])) echo $_POST['user']; ?>"><?php echo $UEr; ?></td>
		</tr>
		<tr>
			<td align="center">Password</td><td><input name="password" type="password"><?php echo $PEr; ?></td>
		</tr>
		<tr>
			<td></td><td align="center">Forgot password<input name="forget" type="checkbox"></td>
		</tr>
		<tr><td colspan="2"align="center" ><input name="submit" type="submit"></td>
		</tr>
		<tr>
			<td colspan="2"align="center"> <?php echo $res; ?> </td>
		</tr>
		<tr><td colspan="2"align="center"> <?php echo $p; echo $forgot; 
					if ($fok==1) {
						echo "<input type = text name =mail>";
						echo "<input name=email type=submit>";

					}

		?> </td></tr>
		</table>
	</form>



</body>
</html>