<?php
include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);


$modBtn = "$_POST[modbtn]";
$modId = "$_POST[modId]";
$modStat = "$_POST[modStat]";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = mysqli_query($conn, "UPDATE $tableName SET modStatus = '$modStat' WHERE unique_id='$modId'");

if (mysqli_query($conn, $sql)) {
 	echo "<p>success</p>";
} 

else {
	header( 'Location: results.php' ) ;

}

mysqli_close($conn);

?>
