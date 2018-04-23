<?php 

// include config file with database
include('config.php');

// get the form type from the URL
$action = get('action');

$id = get('songid');

// get an array of genres
$sql = file_get_contents('sql/getGenres.sql');
$statement = $database->prepare($sql);
$statement->execute();
$genres = $statement->fetchAll(PDO::FETCH_ASSOC);

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

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$song = $_POST['id'];
	$name = $_POST['name'];
	$artist = $_POST['artist'];
	$genre = $_POST['genre'];
	
	if($action == 'add') {
	// add song to database
	$sql = file_get_contents('sql/addSong.sql');
	$params = array(
		'songid' => $song,
		'songname' => $name,
		'artist' => $artist
	);
	
	$statement = $database->prepare($sql);
	$statement->execute($params);
	
	$sql = file_get_contents('sql/addSongGenre.sql');
	$statement = $database->prepare($sql);
	$params = array(
		'songid' => $song,
		'genreid' => $genre
	);
	$statement->execute($params);
	}
	
	elseif($action == 'edit') {
	// edit song to database
	$sql = file_get_contents('sql/editSong.sql');
	$params = array(
		'songid' => $song,
		'songname' => $name,
		'artist' => $artist
	);
	
	$statement = $database->prepare($sql);
	$statement->execute($params);
	
	$sql = file_get_contents('sql/editSongGenre.sql');
	$statement = $database->prepare($sql);
	$params = array(
		'songid' => $song,
		'genreid' => $genre
	);
	$statement->execute($params);
	}
	
	
	header('location: songIndex.php');
}
	
?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Add Song</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Song Recommendations</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>Song-id</label>
				<?php if($action == 'add') : ?>
					<input type="number" name="id" min="1" />
				<?php else : ?>
					<input readonly type="number" name="id" value="<?php echo $song['songid'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element"> 
				<label>Song-name:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="name" class="textbox" />
				<?php else : ?>
					<input type="text" name="name" value="<?php echo $song['songname'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Artist:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="artist" class="textbox" />
				<?php else : ?>
					<input type="text" name="artist" value="<?php echo $song['artist'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Genre:</label>
				<?php foreach($genres as $genre) : ?>
					<?php if($action == 'edit' && $genre['genreid'] == $song_genre['genreid']) : ?>
						<input checked type="radio" name="genre" value="<?php echo $genre['genreid'] ?>" /><?php echo $genre['name'] ?><br />
					<?php else : ?>
						<input type="radio" name="genre" value="<?php echo $genre['genreid'] ?>" /><?php echo $genre['name'] ?><br />
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<input type="submit" />&nbsp;
				<input type="reset" />
			</div>
		</form>
	</div>
</body>
</html>