<?php

// Create and include a configuration file with the database connection
include('config.php');

$queue = $_SESSION['queue'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_destroy();
	header('location: viewQueue.php');
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Queue list</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Queue</h1>
		<form action="" method="POST">
			<ol>
				<?php foreach($queue as $k => $v) : ?>
					<li><?php echo "<strong>" . $k . "</strong>" . " - " . "\"" . $v . "\"" ?></li>
				<?php endforeach; ?>
			</ol>
			<input type="submit" value="Clear Queue" />
			<a href="songIndex.php">Song Index</a>
		</form>
	</div>
</body>
</html>