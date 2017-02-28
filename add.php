<?php
session_start();
$loguser = $_SESSION['user'];
$role = $_SESSION['role']; 
require_once 'a1.lib';

if ($_SESSION['user']) {

$link = new DBLink();
$titleErr="";
$descErr="";
$supCodeErr="";
$costErr="";
$priceErr="";
$onHandErr="";
$rPointErr="";
$backOrderErr="";

$extitle = '/^[A-Za-z\-,:;\'0-9]+$/';
$exdesc = '/^[a-zA-Z0-9.,\'\- \n]+$/';
$exsupCode = '/^[a-zA-Z0-9\-]+$/';
$excost = '/^[0-9]+[.][0-9]{2}$/';
$exprice = '/^[0-9]+[.][0-9]{2}$/';
$exonHand = '/^[0-9]+$/';
$exrPoint = '/^[a-z\-, :;\'0-9]+$/';


$dataValid = true;






if ($_POST) { 
        
	if ($_POST['title'] == "") {
		$titleErr = "Error - you must fill in a name(eg. Oleg)";
		$dataValid = false;
	}
	if (!preg_match($extitle,$_POST['title'])) {
		$titleErr = "Please, enter the title (eg. Oleg)";
		$dataValid = false;
	}


	if ($_POST['desc'] == "") {
		$descErr = "Please, enter the description";
		$dataValid = false;		
	}
	if (!preg_match($exdesc,$_POST['desc'])) {
		$descErr = "Please, enter the description";
		$dataValid = false;
	}


	if (empty($_POST['supCode'])) {
		$supCodeErr = "Please, enter the supplier code";
		$dataValid = false;		
	}
	if (!preg_match($exsupCode,$_POST['supCode'])) {
		$supCodeErr = "Please, enter the supplier code";
		$dataValid = false;
	}


	if (empty($_POST['cost'])) {
		$costErr = "Error - you must fill in a cost (Example: 1.02)";
		$dataValid = false;		
	}
	if (!preg_match($excost,$_POST['cost'])) {
		$costErr = "Error - you must fill in a cost in a monetary format (Example: 1.02)";
		$dataValid = false;
	}



	if (empty($_POST['price'])) {
		$priceErr = "Enter the price (Example: 9.99)";
		$dataValid = false;		
	}
	if (!preg_match($exprice,$_POST['price'])) {
		$priceErr = "Enter the price in a monetary format (Example: 9.99)";
		$dataValid = false;
	}


	if (empty($_POST['onHand'])) {
		$onHandErr = "Error - you must fill in a On Hand";
		$dataValid = false;		
	}
	if (!preg_match($exonHand,$_POST['onHand'])) {
		$onHandErr = "Error - you must fill in a On Hand";
		$dataValid = false;
	}



	if (empty($_POST['rPoint'])) {
		$rPointErr = "Error - you must fill in a Reorder Point";
		$dataValid = false;		
	}
	if (!preg_match($exrPoint,$_POST['rPoint'])) {
		$rPointErr = "Error - you must fill in a Reorder Point";
		$dataValid = false;
	}


	if (empty($_POST['backOrder'])) {
		$backOrderErr = "Error - you must fill in a Back Order";
		$dataValid = false;		
	}

}	


if ($_GET['id'] && $dataValid) {
	
	$id = (int)$_GET['id'];
	$sql_query = "SELECT * from inventory where id = '$id'";

//echo "id is".$id;
$link->query($sql_query);
$result = $link->query($sql_query);
if($result->num_rows != 0) {
	$row = $result->fetch_assoc();
	$data = array(
		"itemName" => $row['itemName'],
		"description" => $row['description'],
		"supplierCode" => $row['supplierCode'],
		"cost" => $row['cost'],
		"price" => $row['price'],
		"onHand" => $row['onHand'],
		"reorderPoint" => $row['reorderPoint'],
		"backOrder" => $row['backOrder'],
		"deleted" => $row['deleted']
	);
	//print_r($data);
} else {
	echo "Fake data! We got you!";
}


}



if ($_POST && $dataValid) { 




//$link = new DBLink();


 $itemName = $_POST['title'];
 $description = $_POST['desc'];
 $supplierCode = $_POST['supCode'];
 $cost = $_POST['cost'];
 $price = $_POST['price'];
 $onHand = $_POST['onHand'];
 $reorderPoint = $_POST['rPoint'];
 $backOrder = $_POST['backOrder'];

/*
 $itemName = mysqli_real_escape_string($link->link(), $itemName);
 $description = mysqli_real_escape_string($link->link(), $_POST['desc']);
 $supplierCode = mysqli_real_escape_string($link->link(), $_POST['supCode']);
 $cost = mysqli_real_escape_string($link->link(), $_POST['cost']);
 $price = mysqli_real_escape_string($link->link(), $_POST['price']);
 $onHand = mysqli_real_escape_string($link->link(), $_POST['onHand']);
 $reorderPoint = mysqli_real_escape_string($link->link(), $_POST['rPoint']);
 $backOrder = mysqli_real_escape_string($link->link(), $_POST['backOrder']);
*/	


if(!$id ==""){
	$sql_query = 'UPDATE inventory set itemName="' . $itemName . '", description="' . $description . '",
 supplierCode="' . $supplierCode . '",cost="' . $cost . '", price="' . $price . '", onHand="' . $onHand . '",
 reorderPoint="' . $reorderPoint . '",backOrder="' . $backOrder . '", deleted="' . $deleted . '" where id = ' . $id .' ';
}

else {
$sql_query = 'INSERT INTO inventory set itemName="' . $itemName . '", description="' . $description . '",
supplierCode="' . $supplierCode . '",cost="' . $cost . '", price="' . $price . '", onHand="' . $onHand . '",
reorderPoint="' . $reorderPoint . '",backOrder="' . $backOrder . '", deleted="' . $deleted . '"';

}
// For debugging purposes
	//	print $sql_query;

//Run our sql query
 		// $result = mysqli_query($link, $sql_query) or die('query failed'. mysqli_error($link));
 		// mysqli_close($link);

$link->query($sql_query);

// Get all records now in DB
		
header('Location: view.php');



		



//if ($result)
//	echo "Da";
//else
//	echo "No";


} else { 
?>


<?php include 'a21.lib'; ?>

<div class="main">
<div style = "margin: 0 auto; width: 400px;">
<form method="post" action="">
	<table>
	<tr>
		<td align="left">Name</td> 
	<td align="left"><input type = "text" name = "title" value="<?php if ($_GET['id']) echo $data['itemName']; if (isset($_POST['title'])) echo $_POST['title']; ?>"><span class="red"><?php echo $titleErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Description</td> 
	<td align="left"> <textarea name="desc" rows="3" cols="15"><?php if ($_GET['id']) echo $data['description'];  if (isset($_POST['desc'])) echo $_POST['desc']; ?></textarea><span class="red"><?php echo $descErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Supplier Code</td> 
	<td align="left"> <input type = "text" name = "supCode" value="<?php if ($_GET['id']) echo $data['supplierCode'];  if (isset($_POST['supCode'])) echo $_POST['supCode']; ?>"><span class="red"><?php echo $supCodeErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Cost</td> 
	<td align="left"> <input type = "text" name = "cost" value="<?php if ($_GET['id']) echo $data['cost'];  if (isset($_POST['cost'])) echo $_POST['cost']; ?>"><span class="red"><?php echo $costErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Price</td> 
	<td align="left"> <input type = "text" name = "price" value="<?php if ($_GET['id']) echo $data['price'];  if (isset($_POST['price'])) echo $_POST['price']; ?>"><span class="red"><?php echo $priceErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">On Hand</td> 
	<td align="left"> <input type = "number" name = "onHand" value="<?php if ($_GET['id']) echo $data['onHand'];  if (isset($_POST['onHand'])) echo $_POST['onHand']; ?>"> <span class="red"><?php echo $onHandErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Reorder Point</td> 
	<td align="left"> <input type = "number" name = "rPoint" value="<?php if ($_GET['id']) echo $data['reorderPoint'];  if (isset($_POST['rPoint'])) echo $_POST['rPoint']; ?>"><span class="red"><?php echo $rPointErr;?></span>
	</td>
	</tr>
	<tr>
		<td align="left">Back Order</td> 
	<td align="left"> <input type = "text" name = "backOrder" value="<?php if ($_GET['id']) echo $data['backOrder'];  if (isset($_POST['backOrder'])) echo $_POST['backOrder']; ?>"><span class="red"><?php echo $backOrderErr;?></span>
	</td>
    </tr>
	<tr>
	<td></td>
	<td><input name="submit" type="submit"></td>
	</tr>
</form>
</div>
</div>


<?php
    }
}


else {
		header("Refresh:3;url=login.php");
		echo "You are redirecting to a login page. Wait 5 seconds";


}
?>

