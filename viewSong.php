<?php 

// include config file with database
include('config.php');

// get the form type from the URL
$action = get('action');

$id = get('songid');

$song = null;
$song_genre = null;

if(!empty($id)) {
	$sql = file_get_contents('sql/getSong.sql');
	$params = array(
		'songid' => $id
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$songs = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$song = $songs[0];
	
	$sql = file_get_contents('sql/getSongGenre.sql');
	$params = array(
		'songid' => $id
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$song_genres = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$song_genre = $song_genres[0];
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$queue = $_SESSION['queue'];
	$queue->addToQueue($song);
	header('location: viewQueue.php');
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Song</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Song Description</h1>
		<form action="" method="POST">
		<?php echo "<strong>Artist: </strong>" . $song['artist'] ?><br />
		<?php echo "<strong>Title: </strong>" . $song['songname'] ?><br />
		<?php echo "<strong>Genre: </strong>" . $song_genre['name'] ?><br />
		<input type="submit" value="add to Queue" />
		</form>
	</div>
</body>
</html>