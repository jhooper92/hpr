<?php
	session_start();
	$prevURL = $_SESSION['prevURL'];
?>

<h1>Review Unsuccesful</h1>
<p>Your review could not be submitted as you have already left a review for this item.</p>
<p> Please contact the company you have tried to leave the review for if you wish to amend or remove your review </p>

<a href='<?php echo $prevURL; ?>'>Return to page</a>
