<?php 

// include config file with database
include('config.php');

// get Survey results
$sql = file_get_contents('sql/getResults.sql');
$statement = $database->prepare($sql);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>User results</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Results:</h1>
		<?php foreach($results as $result) : ?>
			<p>
				<?php echo "<strong>Name: </strong>" . $result['name']; ?><br />
				<?php echo "<strong>Gender: </strong>" . $result['gender']; ?><br />
				<?php echo "<strong>Genre: </strong>" . $result['genre']; ?><br />
				<?php echo "<strong>Hours: </strong>" . $result['hoursperday']; ?><br />
				<?php echo "<strong>Favorite Song: </strong>" . $result['favsong']; ?><br />
				<a href="form.php?action=edit&surveyid=<?php echo $result['surveyid'] ?>">Edit Answer</a><br />
			</p>
		<?php endforeach; ?>
		<a href="song.php?action=add">Add a Song</a>
	</div>
</body>
</html>
		