<!DOCTYPE html>
<html>

<head>
	<title>Browse Strains</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body><center>

<h1>Browse All Strains</h1>

<?php
/* 
 * The number of results per page, can be changed at will
 */
$num_per_page = 25;

/* 
 * This tells you what page you are on, and if you haven't started sets it to 1.
 */
if (isset($_GET['num'])){
	$num = $_GET['num'];
}
else{
	$num = 1;
}

$offset = ($num - 1) *$num_per_page;


/* Connection Variables at top
 * Makes it easy to change is necessary */
$server = "localhost";
$username = "csandall";
$password = "";
$database = "csandall";

$connect = mysqli_connect($server, $username, "", $database);

if($connect->connect_error){
	echo "Something has gone horribly wrong";
	echo "Connection error:" .$connect->connect_error;
	die();
}

/* Query to count the number of pages present for pagenation
 * After this, we calculate the amount of pages that will be necessary
 */
$total_page_query = "SELECT COUNT(isolate) FROM organism_info;";
$numpages_result = mysqli_query($connect, $total_page_query);
$total_row = mysqli_fetch_array($numpages_result)[0];
$total_pages = ceil($total_row / $num_per_page);

/* 
 * Initial query to return foregn key for other databases
 */
$query = "SELECT * FROM organism_info LIMIT $offset, $num_per_page;";
$data = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($data)){
	/* Code to print out the first three results from one table
	 */
	print("<strong>Strain: </strong>");
	print($row[0]);
	print("<strong> Isolate: </strong>");
	print($row[1]);
	print("<strong> Date: </strong>");
	print($row[2]);
	print(" ");
	
	/* 
	 * Query to retrieve info from other tables for records
	 * Copied from above section
	 */
	$query2 = "SELECT sra_number FROM sequence_read WHERE isolate = '$row[1]';";
	$query3 = "SELECT refseq_number FROM assembly WHERE isolate = '$row[1]';";
	$data2 = mysqli_query($connect, $query2);
	$data3 = mysqli_query($connect, $query3);
	while($row2 = mysqli_fetch_array($data2)){
		$sra_link = "<a href='https://www.ncbi.nlm.nih.gov/biosample/?term=$row2[0]' title='SRA' target='_blank'>SRA</a>";
		print($sra_link);
		print(" ");
	}
	while($row3 = mysqli_fetch_array($data3)){
		$sra_link_assem = "<a href='https://www.ncbi.nlm.nih.gov/assembly/?term=$row3[0]' title=' Assembly' target='_blank'>Assembly</a>";
		print($sra_link_assem);
	}
	print("<br />");
	print("<br />");
}

/* 
 * Closing connection for others
 */
mysqli_close($connect);

?>

<!-- Pagenation buttons idea curteosy of W3 schools. Modified as necessary for own usage -->
<ul class="pagination">
        <li><a href="?num=1">First</a></li>
        <li class="<?php if($num <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($num <= 1){ echo '#'; } else { echo "?num=".($num - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($num >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($num >= $total_pages){ echo '#'; } else { echo "?num=".($num + 1); } ?>">Next</a>
        </li>
        <li><a href="?num=<?php echo $total_pages; ?>">Last</a></li>
</ul>

</center></body>

</html>
