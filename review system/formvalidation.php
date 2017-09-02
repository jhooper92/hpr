<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaijaan" rel="stylesheet">
<style>

.row.error {
    text-align: center;
    padding: 10px;
    background-color: lightcoral;
    margin: 5px;
    font-family: 'Baloo Bhaijaan', cursive;
    color:#fff;
}



</style>
<?php

include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);

	$date_stamp = date("d.m.y H:i:s");
	$ccr_id = "$_POST[ccr_id]";
	$prevURL = "$_POST[ccr_url]"; 

	$errors = array();

	if (empty($_POST['ccr_nickname'])) {
		$errors[] = "<div class='row error'>Enter A nickname</div>";
		$nickname = "";
	}
	else {
		$nickname = trim($_POST['ccr_nickname']);
		$nickname = htmlspecialchars($nickname);
	}

	if (empty($_POST['ccr_email']))
		{$errors[] = "<div class='row error'>Enter Your Email</div>";
		$email = "";
	}
	else {
		$email = trim($_POST['ccr_email']);
		$email = htmlspecialchars($email);
	}

	if (!isset($_POST['ccr_rating']))
		{$errors[] = "<div class='row error'>Enter A Rating</div>";
		$rating = "";
	}
	else {
		$rating = trim($_POST['ccr_rating']);
		$rating = htmlspecialchars($rating);
	}

	if (empty($_POST['ccr_ReviewTitle']))
		{$errors[] = "<div class='row error'>Enter a Review Title</div>";
		$ReviewTitle = "";
	}
	else {
		$ReviewTitle = trim($_POST['ccr_ReviewTitle']);
		$ReviewTitle = htmlspecialchars($ReviewTitle);
	}

	if (empty($_POST['ccr_message']))
		{$errors[] = "<div class='row error'>Enter A message</div>";
		$message = "";
	}
	else {
		$message = trim($_POST['ccr_message']);
		$message = htmlspecialchars($message);
	}

	if (!isset($_POST['ccr_recommend']))
		{$errors[] = "<div class='row error'>Enter a recommend</div>";
		$recommend = "";
	}
	else {
		$recommend = trim($_POST['ccr_recommend']);
		$recommend = htmlspecialchars($recommend);
	}


	if (empty($errors))
	{

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
	}

	else {

			foreach ($errors as $msg)
		{echo "$msg";}
		include('form.php');
	}
?>