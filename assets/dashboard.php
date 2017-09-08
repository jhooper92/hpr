<?php

include('../conn.php');
//Connecting to sql db.
$conn = mysqli_connect($serverName,$userName,$userPass,$dbName);
$pageName = $_SERVER['PHP_SELF'];

$limit = 5;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $limit;

setcookie("filter", '');
setcookie("search", '');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['clear'])) {
  setcookie("filter", '');
  setcookie("search", '');
}

	if (isset($_POST['filterBy']) && !empty($_POST['filterBy']) && isset($_POST['searchFor']) && !empty($_POST['searchFor'])) {
		$filterBy = "$_POST[filterBy]";
		$filterByPrint = "$_POST[filterBy]";
		$searchFor = "$_POST[searchFor]";

		$filterBy = trim($filterBy);
		$filterBy = preg_replace('/[^A-Za-z0-9\-]/', '', $filterBy);
		$filterBy = htmlspecialchars($filterBy);

		$searchFor = trim($searchFor);
		$searchFor = preg_replace('/[^A-Za-z0-9\-]/', '', $searchFor);
		$searchFor = htmlspecialchars($searchFor);

		setcookie("filter", $filterBy);
		setcookie("search", $searchFor);

		$countsql = "SELECT COUNT(unique_id) FROM $tableName WHERE modStatus= '$filterBy' AND CCR_id= '$searchFor'";

		$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE modStatus= '$filterBy' AND CCR_id= '$searchFor' ORDER BY reg_date DESC LIMIT $start_from, $limit");

				switch ($filterByPrint) {
				    case "APP":
				        $filterResult = " Approved Reviews";
				        break;
				    case "REJ":
				        $filterResult = ' Rejected Reviews';
				        break;
				    case "PEND":
				        $filterResult = " Reviews Pending Moderation";
				        break;
				}

		$filteredComment = "<p class='currentfilter'> Filtered By: " . $filterResult . " &amp; " . $searchFor . "</p>";
	}

	elseif (isset($_POST['searchFor']) && !empty($_POST['searchFor'])) {
		$searchFor = "$_POST[searchFor]";

		$searchFor = trim($searchFor);
		$searchFor = preg_replace('/[^A-Za-z0-9\-]/', '', $searchFor);
		$searchFor = htmlspecialchars($searchFor);

		setcookie("search", $searchFor);
		setcookie("filter", "");

		$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE CCR_id= '$searchFor' ORDER BY reg_date DESC LIMIT $start_from, $limit");
		$countsql = "SELECT COUNT(unique_id) FROM $tableName WHERE CCR_id= '$searchFor'";
		$filteredComment = "<p class='currentfilter'> Filtered By: " . $searchFor . "</p>";
	}

	elseif (isset($_POST['filterBy']) && !empty($_POST['filterBy']) ) {
		$filterBy = "$_POST[filterBy]";

		$filterBy = trim($filterBy);
		$filterBy = preg_replace('/[^A-Za-z0-9\-]/', '', $filterBy);
		$filterBy = htmlspecialchars($filterBy);

		setcookie("filter", $filterBy);
		setcookie("search", "");

		$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE modStatus= '$filterBy' ORDER BY reg_date DESC LIMIT $start_from, $limit");
		$countsql = "SELECT COUNT(unique_id) FROM $tableName WHERE modStatus= '$filterBy'";

				switch ($filterBy) {
				    case "APP":
				        $filterResult = " Approved Reviews";
				        break;
				    case "REJ":
				        $filterResult = ' Rejected Reviews';
				        break;
				    case "PEND":
				        $filterResult = " Reviews Pending Moderation";
				        break;
				}

		$filteredComment = "<p class='currentfilter'> Filtered By: " . $filterResult . "</p>";
	}

	else {

		$result = mysqli_query($conn,"SELECT * FROM $tableName ORDER BY reg_date DESC LIMIT $start_from, $limit");
		$filteredComment = "";

		if(isset($_COOKIE['search']) && isset($_COOKIE['filter']) ) {
			$cookieSearch = $_COOKIE['search'];
			$cookieFilter = $_COOKIE['filter'];
			$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE modStatus= '$cookieFilter' AND CCR_id= '$cookieSearch' ORDER BY reg_date DESC LIMIT $start_from, $limit");

			switch ($cookieFilter) {
				    case "APP":
				        $filterResult = " Approved Reviews";
				        break;
				    case "REJ":
				        $filterResult = ' Rejected Reviews';
				        break;
				    case "PEND":
				        $filterResult = " Reviews Pending Moderation";
				        break;
				}

			$filteredComment = "<p class='currentfilter'> Filtered By: " . $filterResult . " &amp; " . $cookieSearch . "</p>";
		}

		elseif(isset($_COOKIE['search']) && !isset($_COOKIE['filter']) ) {
			$cookieSearch = $_COOKIE['search'];
			$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE CCR_id= '$cookieSearch' ORDER BY reg_date DESC LIMIT $start_from, $limit");
			$filteredComment = "<p class='currentfilter'> Filtered By: " . $cookieSearch .  "</p>";
		}

		elseif(isset($_COOKIE['filter']) && (!empty($_COOKIE['filter'])) && !isset($_COOKIE['search']) ) {
			$cookieFilter = $_COOKIE['filter'];
			$result = mysqli_query($conn,"SELECT * FROM $tableName WHERE modStatus= '$cookieFilter' ORDER BY reg_date DESC LIMIT $start_from, $limit");
			switch ($cookieFilter) {
				    case "APP":
				        $filterResult = " Approved Reviews";
				        break;
				    case "REJ":
				        $filterResult = ' Rejected Reviews';
				        break;
				    case "PEND":
				        $filterResult = " Reviews Pending Moderation";
				        break;
				}
			$filteredComment = "<p class='currentfilter'> Filtered By: " . $filterResult . "</p>";
		}

		$countsql = "SELECT COUNT(unique_id) FROM $tableName";
	}

?>
<div class="row">
	<form class='button filter' action='' method='post'>
		<select name="filterBy">
			<option value="">All Reviews</option>
			<option value="REJ">Rejected Reviews</option>
			<option value="APP">Approved Reviews</option>
			<option value="PEND">Pending Reviews</option>
		</select>
		<input type="text" class="filterby" name="searchFor" placeholder="Search for product">
		<input type="submit" class="filterby" value="Filter">
	</form>
	<?php
		if (isset($_POST['filterBy']) && !empty($_POST['filterBy']) || isset($_POST['searchFor']) && !empty($_POST['searchFor']) || isset($_COOKIE['filter']) && !empty($_COOKIE['filter']) || isset($_COOKIE['search']) && !empty($_COOKIE['search'])) {
			echo "<div class='row filterResults'>" . $filteredComment;
			//echo "<a class='clearFilter' href='assets/clearcookies.php'>X</a></div>";
      echo "<form action='assets/clearcookies.php' method='post'><input type='hidden' name='clear' value='clear'><input type='submit' value='clear'></form>";
		}

	?>
</div>
<?php

    while($row = mysqli_fetch_array($result)) {

    	switch ($row['modStatus']) {
		    case "APP":
		        $modStatus = "Approved";
		        break;
		    case "REJ":
		        $modStatus = 'Rejected';
		        break;
		    case "PEND":
		        $modStatus = "Pending Moderation";
		        break;
		}

    	$mod_App = "<form class='button approve' action='assets/dash_moderation.php' method='post'> <input type='hidden' name='modId' value ='" . $row['unique_id'] . "'><input type='hidden' name='modStat' value='APP'><input type='submit' value='Approve Review'></form>";
    	$mod_Rej = "<form class='button decline' action='assets/dash_moderation.php' method='post'> <input type='hidden' name='modId' value ='" . $row['unique_id'] . "'><input type='hidden' name='modStat' value='REJ'><input type='submit' value='Reject Review'></form>";

    	echo "<div class='ccr_dash_row'><p>Review ID:<span> " . $row['unique_id'] . "</span> | Product Code:<span> " . $row['CCR_id'] . "</span></p><p> Rating:<span> " . $row['rating'] . "</span></p><p>Nickname:<span> " . $row['nickname'] . "</span></p><p> Submission Date:<span>" . $row['reg_date'] . "</p><p> Current Status:<span> " . $modStatus . "</span></p>" ;

    			echo "<div class='description'><p>" . $row['ReviewTitle'] . "<p>" . $row['message'] . "</p></div>";

    	if ($row['modStatus'] === "PEND")
    		{
    			echo $mod_App . $mod_Rej . "</div>";
    		}

		if ($row['modStatus'] == "APP")
		{
			echo $mod_Rej . "</div>";

		}

		if ($row['modStatus'] == "REJ")
		{
			echo $mod_App . "</div>";
		}

      }

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


		if ($total_records === "0") {
			echo "<p>No Reviews Found</p>";
		}

    mysqli_close($conn);

?>
</div>
</div>
