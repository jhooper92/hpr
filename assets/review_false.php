<?php
	session_start();
	$prevURL = $_SESSION['prevURL'];
?>
<div class="review_return">
	<p>Your review could not be submitted as you have already left a review for this item.</p>
	<p> Please contact the company you have tried to leave the review for if you wish to amend or remove your review </p>
</div>
<a class="btn ccr_finish" href='<?php echo $prevURL; ?>'>Return to page</a>
