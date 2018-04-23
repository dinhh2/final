<?php 

// include config file with database
include('config.php');

$term = get('term');

$songs = findSongs($term, $database);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Songs</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Songs</h1>
		<form method="GET">
			<input type="text" name="term" />
			<input type="submit" />
		</form>
		<?php foreach($songs as $song) : ?>
			<p>
				<?php echo "<strong>" . $song['artist'] . "</strong>" . " - " . "\"". $song['songname'] . "\""; ?><br />
				<a href="song.php?action=edit&songid=<?php echo $song['songid'] ?>">Edit Song</a>
				<a href="viewSong.php?songid=<?php echo $song['songid'] ?>">View Description</a>
			</p>
		<?php endforeach; ?>
	</div>
</body>
</html>