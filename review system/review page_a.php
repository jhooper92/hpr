

<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaijaan" rel="stylesheet">
<style>

body {
	background-color:#f6f6f6;
}

.mainwrap {
	width:50%;
	margin:auto;

}

.innerwrap {
	padding:2em;
	width:100%;
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

input, strong, option {
	border:none;
	font-family: 'Baloo Bhaijaan', cursive;
	font-weight:regular;
	font-size:16px;
	margin:5px;
	padding:5px;
	border-bottom:1px solid lightgrey;
}

h2, p {
	font-family: 'Baloo Bhaijaan', cursive;
	font-weight:regular;
}

.reg_errors {
	border-bottom:1px solid lightgrey;
}

.reg_errors h2, .reg_errors p {
	color:#ff3e45;
}

#err_msg {
	line-height:1.5;
}

.user_deet {
	color:lightgrey;
	font-size:14px;
	text-transform:uppercase;
}

.box, .categoryblock {
	width:23.7%;
	margin:.5%;
	background-color:white;
	border:1px solid #d1d1d1;
	padding:10px 0;
	display:block;
	float:left;
	box-shadow:0 4px 6px -2px rgba(0,0,0,.2);
	
}

.categoryblock h2 {
	margin:0px;
	padding:0px;
	color:#0053a0;
}


.categoryblock a h2 {
	text-decoration:underline;
}

.categoryblock {
	text-align:center;
	text-transform:uppercase;
}

.review_row {
	display:block;
	float:left;
	width:100%;
	margin-bottom:10px;
	background:#fff;
	border:1px solid #d3d3d3;
}

p {
	float:left;
	display:inline-block;
	width:100%;
	clear:left;
	padding-left:10px;
}

form.button input {
	margin:10px 1em 10px 0;
	padding:5px;
	background:black;
	display:inline-block;
	float:left;
}

form.button.approve input {
	background:green;
	color:black;
}

form.button.decline input {
	background:red;
	color:white;
}

p.recommend {
    font-size: 71px;
    line-height: 1;
    margin: 0;
}

.left, .right {
	width:auto;
	display:block;
	float:left;
	padding:5px;
}

.right img {
	max-height:52px;
}

.left {
	border-right: 2px dashed black;
	padding:5px 40px 5px 5px;
	margin:15px 0 15px 15px;
}

.left p {
	margin:0;
	font-family: 'Baloo Bhaijaan', cursive;
	font-weight:regular;
	text-align:center;
}

.main_row {
	margin-bottom:20px;
	display:table;
	font-family:arial;
	width:100%;
	background-color:#fff;
	border:1px solid #d3d3d3;
}

.rating {
	display:block;
	float:left;
	font-family: 'Baloo Bhaijaan', cursive;
	font-weight: regular; 
	font-size:40px;
}

.right {
		margin-top:18px;
}

.stars {
	float:left;
	margin-right:15px;
	margin-left:15px;
}

input.write_btn {
	background:green;
	color:#fff;
	padding:5px 10px;
	text-decoration:none;
}

.left.review {
	border:none;
	width:20%;
}

.right.review {
	border-left:2px black dashed;
	margin:10px 0;
	width:70%;
}

.review_row img {
	max-height:20px;
}

p.review_title {
	color:#000;
	font-size:20px;
}

.description p {
	color:grey;
}

.pagination {
	display:inline-block;
	float:right;
}

.pagination .pageBtn {
	padding:15px;
	background:grey;
	color:white;
	margin-left:10px;
	margin-top:10px;
	margin-bottom:10px;
	display:inline-block;
}

p.overallRating {
	margin:0;
}

</style>

<?php $CCR_id = "ABC456"; ?>
<div class="mainwrap">
<div class="innerwrap">
<h1> Product <?php echo $CCR_id ?></h1>

<?php
include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);

$pageName = "review page_b";
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

	<form action='form.php' method='post'>
		<input type="hidden" name="ccr_id" value="<?php echo $CCR_id?>">
		<input type="hidden" name="url" value="/coffeecupreviews/review page_b.php">
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
		             $pagLink .= "<a class='pageBtn' href='" . $pageName . ".php?page=".$i."'>".$i."</a>";  
		};  
		
		if ($total_records > $limit){
		echo $pagLink . "</div>";
		}


    mysqli_close($conn);

?>
</div>
</div>