<?php 
session_start();
$loguser = $_SESSION['user'];
$role = $_SESSION['role']; 

 include 'a1.lib';
if ($_SESSION['user']) {

$variab = $_GET['id'];
$change = $_GET['change'];

          
$link = new DBLink();



if($link) {

if ($change=='n') {
 $sql_query = 'update inventory set deleted=\'y\' where id='.$variab;
   $link->query($sql_query);
  } 

 else {
    $sql_query = 'update inventory set deleted=\'n\' where id='.$variab;
	  $link->query($sql_query);
  }

           
     } 
      unset($link);
      header("Location: view.php");
}



else {
		header("Refresh:3;url=login.php");
		echo "You are redirecting to a login page. Wait 5 seconds";


}

 



        // get the final result in database.
?>
