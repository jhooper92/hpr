<style>

body {
	background-color:#f6f6f6;
}

.mainwrap {
	width:30%;
	margin:auto;

}

.innerwrap {
	background-color:#fff;
	box-shadow:0 4px 6px -2px rgba(0,0,0,.2);
	padding:2em;

}

.boxleft {
	width:49%;
	background-color:#fff;
	box-shadow:0 4px 6px -2px rgba(0,0,0,.2);
	margin:15px 1% 0 0 ;
	display:block;
	float:left;
}

.boxright {
	width:49%;
	background-color:#fff;
	box-shadow:0 4px 6px -2px rgba(0,0,0,.2);
	margin:15px 0 0 1% ;
	display:block;
	float:left;
}

a {
	text-decoration:none;
	text-align:center;
	color:#d1d1d1;
}

a:hover {
	color:#000;
}

</style>
<?php
include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);

$nickname = "$_POST[ccr_nickname]";
$email = "$_POST[ccr_email]";
$rating = "$_POST[ccr_rating]";
$ReviewTitle = "$_POST[ccr_ReviewTitle]";
$message = "$_POST[ccr_message]";
$recommend = "$_POST[ccr_recommend]";
$date_stamp = date("d.m.y H:i:s");
$ccr_id = "$_POST[ccr_id]";
$prevURL = "$_POST[ccr_url]"; 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO review_hold (CCR_id, nickname, email, rating, ReviewTitle, message, reg_date, modStatus, recommend)
VALUES ( '$ccr_id', '$nickname' , '$email' , '$rating', '$ReviewTitle', '$message', '$date_stamp' , 'PEND', '$recommend')";

if (mysqli_query($conn, $sql)) {
    echo "<div class='mainwrap'><div class='innerwrap'>
<h1> Thanks </h1>
<p> Your review has been submitted </p>
	<a href='" . $prevURL . "'>Return to page</a></div></div>";
} else {
    echo "
    <div class='mainwrap'>
    	<div class='innerwrap'>
			<h1> There seems to have been an issue</h1>
			<p> Uh oh something has fucked up</p>
		</div>
	</div>";

}

mysqli_close($conn);

?>

