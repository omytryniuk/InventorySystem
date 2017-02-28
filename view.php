<?php 
session_start();
$loguser = $_SESSION['user'];
$role = $_SESSION['role']; 
//$order = $_SESSION['order']; 
if ($_SESSION['user']) {
	//echo $da. ", welcome back";
/*$isSecure = 1;
if (isset($_SERVER['HTTPS'])) {
    $isSecure = 2;echo "Secure is ".$isSecure. " da";
}*/


if (isset($_COOKIE['order'])) {
	$va = $_COOKIE["order"];

//	echo "ses";
}

if (($_COOKIE["order"] != $_GET['val']) && ($_GET['val'])) {
	$va = $_GET['val'];
	setcookie("order",$_GET['val'],time()+86400*30);
//	$va = $_COOKIE["order"];
	
}

//echo $_GET['val'];




	//if($va)
	// echo $va;



//$lines = file('C:\xampp\new\htdocs\secret\topsecret');


?>

<?php include 'a1.lib';  ?>
<?php include 'a21.lib';  ?>


<div class="main">
<table class ="show" border = "1">
<tr>
<th><a href="view.php?val=itemName">Items</a></th><th><a href="view.php?val=description">Description</a></th><th><a href="view.php?val=supplierCode">Supplier Code</th>
<th><a href="view.php?val=cost">Cost</th>
<th><a href="view.php?val=price">Price</th><th><a href="view.php?val=onHand">On Hand</th>
<th><a href="view.php?val=reorderPoint">Reorder Point</th><th><a href="view.php?val=backOrder">Back Order</th><th>Delete/Restore</th>
<?php
	 $link = new DBLink();

	if (isset($_POST['searchbutton']) && ($_POST['search']) !="") {
		$keyword = $_POST['search'];
		$sql_query = "SELECT * from inventory where description like \"%$keyword%\" ";
	}
	

	else {
		$sql_query = "SELECT * from inventory order by '$va'";}
		
	//Run our sql query
 	$result = $link->query($sql_query);
 	 	/*if (!$result) {
 		return false;

	}*/
 	if($result->num_rows == 0) {
 		?>  
<p text-align ="center"> The line can not be found </p>


 		<?php  
 	}




 		while($row = $result->fetch_assoc())
 		{ 
 			
 ?>
 		<tr>
 		<td><a href="add.php?id=<?php echo $row['id']; ?>"><?php print $row['itemName']; ?></a></td>
 		<td><?php print $row['description'];?></td>
 		<td><?php print $row['supplierCode'] ;?></td>
 		<td><?php print $row['cost'];?></td>
 		<td><?php print $row['price'];?></td>
 		<td><?php print $row['onHand'];?></td>
 		<td><?php print $row['reorderPoint'];?></td>
 		<td><?php print $row['backOrder'];?></td>
 		<?php if ($row['deleted']=='n') { ?>
 			<td><a href="delete.php?id=<?php echo $row['id'] ?>&change=<?php echo $row['deleted']?>">Delete</a></td></tr>
 		<?php } else { ?>
 			<td><a href="delete.php?id=<?php echo $row['id'] ?>&change=<?php echo $row['deleted']?>">Restore</a></td></tr>
 		<?php }  

 					 ?> 

 		


	    
<?php
 	  
 	 }
 	
 	 unset($link);

?>

</table>
</div>

<?php
}

else {

		header("Refresh:3;url=login.php");
?>
		<div align = "center">
		<img align ="center" src="cat.gif" alt="cat" style="width:128px;height:128px"><br> <br>
<?php
		echo "You are redirecting to a login page. Wait 5 seconds"; ?>

	</div>
		
<?php

}



?>