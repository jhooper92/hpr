<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaijaan" rel="stylesheet">
<style>

body {
	background-color:#f6f6f6;
}

.mainwrap {
	margin:auto;

}

.innerwrap {
	background-color:#fff;
	box-shadow:0 4px 6px -2px rgba(0,0,0,.2);
	padding:2em;
	width:90%;
	display:block;
	float:left;
	margin-bottom:15px;

}

.innerwrapright {
	width:99%;
	margin-left:1%;
	display:block;
	float:left;
	padding:2em;
	box-shadow: 0 4px 6px -2px rgba(0,0,0,.2);
	background-color:#fff;
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

input, strong, option, textarea {
	border:none;
	font-family: 'Baloo Bhaijaan', cursive;
	font-size:16px;
	margin:10px;
	padding:5px;
	background: lightgrey;
}

input[type="text"], textarea {
	width:90%;
}

h2 {
	font-family: 'Baloo Bhaijaan', cursive;
}

span.ccr_required {
	position:absolute;
	color:red;
}


.form-row {
	width:100%;
	position:relative;
}

</style>

<?php 

	$ccr_id = "$_POST[ccr_id]"; 
	$url = "$_POST[ccr_url]"; 

?>

<div class="mainwrap">
	<div class="innerwrap">
		<h2>Leave a Review</h2>
			<form action="formvalidation.php" method="post">
				<p class="ccr_req">Required fields are marked with *</p>
				<div class="form-row nickname">
					<input type="text" name="ccr_nickname" placeholder="Enter a Nickname" value="<?php if (!isset($_POST['ccr_nickname'])) {echo "";} else {echo $nickname;} ?>"><span class="ccr_">*</span>
				</div>

				<div class="form-row email">
					<input type="text" name="ccr_email" type="email" placeholder="Enter Your Email Address" value="<?php if (!isset($_POST['ccr_email'])) {echo "";} else {echo $email;} ?>"><span class="ccr_">*</span>
				</div>

				<div class="form-row title">
				    <input type="text" name="ccr_ReviewTitle" placeholder="Enter a Review Title" value="<?php if (!isset($_POST['ccr_ReviewTitle'])) {echo "";} else {echo $ReviewTitle;} ?>"><span class="ccr_">*</span>
			    </div>

			    <div class="form-row detail">
				    <textarea name="ccr_message" rows="10" cols="30" placeholder="leave more detail about your experience" value="<?php if (!isset($_POST['ccr_message'])) {echo "";} else {echo $message;} ?>"></textarea><span class="ccr_">*</span>
		    	</div>

				<div class="form-row rating">
					<p>How Do You Rate This Product? <span class="ccr_"> *</span></p>
					<input type="radio" name="ccr_rating" id="rating_one" value="1" ><label for="rating_one">1</label>
					<input type="radio" name="ccr_rating" id="rating_two" value="2" ><label for="rating_one">2</label>
					<input type="radio" name="ccr_rating" id="rating_three" value="3" ><label for="rating_one">3</label>
					<input type="radio" name="ccr_rating" id="rating_four" value="4" ><label for="rating_one">4</label>
					<input type="radio" name="ccr_rating" id="rating_five" value="5" ><label for="rating_one">5</label>
				</div>

			    <div class="form-row recommend">
				    <p>Would You Recommend this Product? <span class="ccr_"> *</span></p>
				    <input type="radio" name="ccr_recommend" value="Yes" id="recommend_yes" ><label for="recommend_yes">Yes</label>
				    <input type="radio" name="ccr_recommend" value="No" id="recommend_no" ><label for="recommend_no">No</label>
				</div>

			    <input type="hidden" name="ccr_id" value="<?php echo $ccr_id?>">
			    <input type="hidden" name="ccr_url" value="<?php echo $url?>">
			    <input type="submit" value="submit">
			</form>
	</div>
</div>

