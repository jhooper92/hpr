<?php

	$ccr_id = "$_POST[ccr_id]";
	$url = "$_POST[ccr_url]";

?>
			<form action="form_valid" class="ccr_write_review" method="post">
				<p class="ccr_req">Required fields are marked with *</p>
				<div class="form-row nickname">
					<input type="text" name="ccr_nickname" placeholder="Enter a Nickname" value="<?php if (!isset($_POST['ccr_nickname'])) {echo "";} else {echo $nickname;} ?>"><span class="ccr_req">*</span>
				</div>

				<div class="form-row email">
					<input type="text" name="ccr_email" type="email" placeholder="Enter Your Email Address" value="<?php if (!isset($_POST['ccr_email'])) {echo "";} else {echo $email;} ?>"><span class="ccr_req">*</span>
				</div>

				<div class="form-row title">
				    <input type="text" name="ccr_ReviewTitle" placeholder="Enter a Review Title" value="<?php if (!isset($_POST['ccr_ReviewTitle'])) {echo "";} else {echo $ReviewTitle;} ?>"><span class="ccr_req">*</span>
			    </div>

			    <div class="form-row detail">
				    <textarea name="ccr_message" rows="10" cols="30" placeholder="Enter More Detail About Your Review" value="<?php if (!isset($_POST['ccr_message'])) {echo "";} else {echo $message;} ?>"></textarea><span class="ccr_req">*</span>
		    	</div>

				<div class="form-row rating">
					<p>How Do You Rate This Product? <span class="ccr_req"> *</span></p>
					<input type="radio" name="ccr_rating" id="rating_one" value="1" ><label for="rating_one">1</label>
					<input type="radio" name="ccr_rating" id="rating_two" value="2" ><label for="rating_one">2</label>
					<input type="radio" name="ccr_rating" id="rating_three" value="3" ><label for="rating_one">3</label>
					<input type="radio" name="ccr_rating" id="rating_four" value="4" ><label for="rating_one">4</label>
					<input type="radio" name="ccr_rating" id="rating_five" value="5" ><label for="rating_one">5</label>
				</div>

			    <div class="form-row recommend">
				    <p>Would You Recommend this Product? <span class="ccr_req"> *</span></p>
				    <input type="radio" name="ccr_recommend" value="Yes" id="recommend_yes" ><label for="recommend_yes">Yes</label>
				    <input type="radio" name="ccr_recommend" value="No" id="recommend_no" ><label for="recommend_no">No</label>
				</div>

			    <input type="hidden" name="ccr_id" value="<?php echo $ccr_id?>">
			    <input type="hidden" name="ccr_url" value="<?php echo $url?>">
			    <input type="submit" value="submit">
			</form>
