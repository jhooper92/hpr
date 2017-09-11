<?php

include('../conn.php');

session_start();
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);

	$date_stamp = date("d.m.y H:i:s");
	$ccr_id = "$_POST[ccr_id]";
	$prevURL = "$_POST[ccr_url]";
	$_SESSION['prevURL'] = $prevURL;

	$errors = array();

	if (empty($_POST['ccr_nickname'])) {
		$errors[] = "<div class='row error'>Enter A nickname</div>";
		$nickname = "";
	}
	else {
		$nickname = trim($_POST['ccr_nickname']);
		$nickname = preg_replace('/[^A-Za-z0-9\-]/', '', $nickname);
		$nickname = htmlspecialchars($nickname);
	}

	if (empty($_POST['ccr_email']))
		{$errors[] = "<div class='row error'>Enter Your Email</div>";
		$email = "";
	}
	else {

		if (!filter_var($_POST['ccr_email'], FILTER_VALIDATE_EMAIL)) {
	  		$errors[] = "<div class='row error'>Invalid Email Address</div>";
	  		$email = "$_POST[ccr_email]";
		}

		else {

				$email = "$_POST[ccr_email]";
		}
	}

	if (!isset($_POST['ccr_rating']))
		{$errors[] = "<div class='row error'>Enter A Rating</div>";
		$rating = "";
	}
	else {
		$rating = trim($_POST['ccr_rating']);
		$rating = preg_replace('/[^A-Za-z0-9\-]/', '', $rating);
		$rating = htmlspecialchars($rating);
	}

	if (empty($_POST['ccr_ReviewTitle']))
		{$errors[] = "<div class='row error'>Enter a Review Title</div>";
		$ReviewTitle = "";
	}
	else {
		$ReviewTitle = trim($_POST['ccr_ReviewTitle']);
		$ReviewTitle = htmlspecialchars($ReviewTitle);
		// $ReviewTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $ReviewTitle);
	}

	if (empty($_POST['ccr_message']))
		{$errors[] = "<div class='row error'>Enter A message</div>";
		$message = "";
	}
	else {
		$message = trim($_POST['ccr_message']);
		$message = htmlspecialchars($message);
		// $message = preg_replace('/[^A-Za-z0-9\-]/', '', $message);
	}

	if (!isset($_POST['ccr_recommend']))
		{$errors[] = "<div class='row error'>Enter if you would recommend.</div>";
		$recommend = "";
	}
	else {
		$recommend = trim($_POST['ccr_recommend']);
		$recommend = htmlspecialchars($recommend);
		$recommend = preg_replace('/[^A-Za-z0-9\-]/', '', $recommend);
	}

	if (empty($errors))
	{

		$checkExist = mysqli_query($conn, "SELECT * FROM review_hold WHERE email= '$email' AND ccr_id= '$ccr_id' AND modStatus='APP'");
		$num_rows = mysqli_num_rows($checkExist);

		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}


		if($num_rows == 0){
			$email = trim($_POST['ccr_email']);
			$email = htmlspecialchars($email);



			$sql = "INSERT INTO review_hold (CCR_id, nickname, email, rating, ReviewTitle, message, reg_date, modStatus, recommend)
			VALUES ( '$ccr_id', '$nickname' , '$email' , '$rating', '$ReviewTitle', '$message', '$date_stamp' , 'PEND', '$recommend')";

			if (mysqli_query($conn, $sql)) {
			    echo "<div class='mainwrap'>
									<div class='innerwrap'>
										<div class='review_return'>
											<p> Thank you </p>
											<p> Your review has been submitted </p>
										</div>
										<a href='" . $prevURL . "' class='ccr_finish btn'>Finish</a>
									</div>
								</div>";
			}

			else {
			    echo "
			    <div class='mainwrap'>
			    	<div class='innerwrap'>
							<div class='review_return'>
								<p>There seems to have been an issue and your review could not be submitted</p>
								<p> Please contact the company</p>
							</div>
					</div>
				</div>";
			}
		}



		else{
			   header( 'Location: review_false' );
			}
			mysqli_close($conn);
	}

	else {

			foreach ($errors as $msg)
				{echo "$msg";}
		include('assets/form.php');
	}
?>
