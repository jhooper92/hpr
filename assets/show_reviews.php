<?php
include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);
$limit = 5;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


    $result = mysqli_query($conn,"SELECT * FROM $tableName where CCR_id= '$CCR_id' AND modStatus= 'APP' ORDER BY  reg_date DESC LIMIT $start_from, $limit" );
    
    $result_b = mysqli_query($conn, "SELECT AVG(rating) AS rating FROM $tableName where CCR_id = '$CCR_id' AND modStatus = 'APP'");
    $row = mysqli_fetch_array($result_b);
	$sum = $row['rating'];
	$Rating = round($sum, 1);
	$rating_star = floor($sum);
	$rating_grey = (4 - $rating_star);
	$rating_point = (($Rating - $rating_star)*10);

	$recommendYes = mysqli_query($conn, "SELECT COUNT(recommend) AS ry FROM $tableName WHERE recommend = 'Yes' AND modStatus = 'APP' AND CCR_id = '$CCR_id'");
	$ry = mysqli_fetch_array($recommendYes);
	$ryr = $ry['ry'];

    $recommendNo = mysqli_query($conn, "SELECT COUNT(recommend) AS rn FROM $tableName WHERE recommend = 'No' AND modStatus = 'APP' AND CCR_id = '$CCR_id'");
	$rn = mysqli_fetch_array($recommendNo);
	$rnr = $rn['rn'];


	if (! $sum) {
		echo "no reviews yet";
	}

	else {

		$recommendPercent = ($ryr / ($ryr + $rnr)) *100;
		echo "<div class='main_row' itemprop='aggregateRating' itemscope itemtype='http://schema.org/AggregateRating'><div class='left'><p class='recommend'>" . round($recommendPercent) . "&percnt;</p><p>Would Recommend</p></div>";
		echo "<div class='right'><div class='stars' alt='" . $Rating . " out of 5 Stars' title ='" . $Rating . " out of 5 Stars'>";
		echo str_repeat("<img src='stars/five-stars.png'>", $rating_star);
		echo "<img src='stars/stars_" . $rating_point . "'>";
		echo str_repeat("<img src='stars/stars_0.png'>", $rating_grey);
		echo "</div><div class='rating' itemprop='reviewCount'>(" . round($ryr + $rnr) .")</div> <p class='overallRating' > Overall Rating of <span itemprop='ratingValue'>" . $Rating ."</span> out of 5</p></div></div>";

	} ?>

	<form action='form' method='post'>
		<input type="hidden" name="ccr_id" value="<?php echo $CCR_id?>">
		<input type="hidden" name="ccr_url" value="<?php echo $pageName ?>">
		<input type="submit" class="write_btn" value="Write a Review">
	</form>

<?php
    while($row = mysqli_fetch_array($result)) {

			echo "<div class='review_row' itemprop='review' itemscope itemtype='http://schema.org/Review'><div class='left review'><p><span itemprop='name'>" . $row['nickname'] . "</span> | <span itemprop='datePublished'>" . explode(" ", $row['reg_date'])[0] . "</p>" ;

			echo "<p>" . str_repeat("<img src='stars/five-stars.png'>", $row['rating']) . "</p><p itemprop='reviewRating' itemscope itemtype='http://schema.org/Rating'> Rated this product: <span itemprop='ratingValue'>" . $row['rating'] . "</span><meta itemprop='worstRating' content = '1'><meta itemprop='bestRating' content = '5'></p> <div class='recommend'> <p> Would you recommend:" . $row['recommend'] . "</p></div></div>" ;

			echo "<div class='right review'><p class='review_title' itemprop='name'>" . $row['ReviewTitle'] . "</p>" ;

			echo "<div class='description' itemprop='description'> <p>" . $row['message'] . "</p></div>";

			echo "</div></div>";

      } 

      	$countsql = "SELECT COUNT(unique_id) FROM $tableName WHERE CCR_id= '$CCR_id' AND modStatus= 'APP'"; 
		$rs_result = mysqli_query($conn,$countsql);  
		$pagerow = mysqli_fetch_row($rs_result);  
		$total_records = $pagerow[0];  
		$total_pages = ceil($total_records / $limit);  
		$pagLink = "<div class='pagination'>";  
		for ($i=1; $i<=$total_pages; $i++) {  
		             $pagLink .= "<a class='pageBtn' href='" . $pageName . "?page=".$i."'>".$i."</a>";  
		};  
		
		if ($total_records > $limit){
		echo $pagLink . "</div>";
		}


    mysqli_close($conn);

?>
</div>
</div>