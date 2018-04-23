<?php 

// include config file with database
include('config.php');

// get the form type from the URL
$action = get('action');

$id = get('surveyid');

// get an array of genres
$sql = file_get_contents('sql/getGenres.sql');
$statement = $database->prepare($sql);
$statement->execute();
$genres = $statement->fetchAll(PDO::FETCH_ASSOC);

$survey = null;

if(!empty($id)) {
	$sql = file_get_contents('sql/getSurvey.sql');
	$params = array(
		'surveyid' => $id
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$surveys = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$survey = $surveys[0];
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$genre = $_POST['genre'];
	$hours = $_POST['hours'];
	$favSong = $_POST['song'];
	
	if($action == 'add') {
	// Insert survey into database
	$sql = file_get_contents('sql/addSurvey.sql');
	$params = array(
		'name' => $name,
		'gender' => $gender,
		'genre' => $genre,
		'hours' => $hours,
		'favsong' => $favSong
	);
	
	$statement = $database->prepare($sql);
	$statement->execute($params);
	}
	
	elseif($action == 'edit') {
	// edit survey in database
	$sql = file_get_contents('sql/editSurvey.sql');
	$params = array(
		'surveyid' => $id,
		'name' => $name,
		'gender' => $gender,
		'genre' => $genre,
		'hours' => $hours,
		'favsong' => $favSong
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	
	}
	
	header('location: index.php');
}
?>



<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Music Survey</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Music Survey</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>Name:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="name" class="textbox" />
				<?php else : ?>
					<input type="text" name="name" class="textbox" value="<?php echo $survey['name'] ?>" />		
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Gender:</label>
				<input type="radio" name="gender" value="male">Male<br>
				<input type="radio" name="gender" value="female">Female<br>
				<input type="radio" name="gender" value="other">Other
			</div>
			<div class="form-element">
				<label>Favorite Genre:</label>
				<?php foreach($genres as $genre) : ?>
					<?php if($action == 'edit' && $survey['genre'] == $genre['name']) : ?>
						<input checked type="radio" name="genre" value="<?php echo $genre['name'] ?>" /><?php echo $genre['name'] ?><br />
					<?php else: ?>
						<input type="radio" name="genre" value="<?php echo $genre['name'] ?>" /><?php echo $genre['name'] ?><br />
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<label>How many hours do you listen to music a day?</label>
				<?php if($action == 'add') : ?>
					<input type="number" name="hours" class="textbok" min="1" max="24" />
				<?php else : ?>
					<input type="number" name="hours" class="textbok" min="1" max="24" value="<?php echo $survey['hoursperday'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Favorite Song?</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="song" class="textbox" />
				<?php else : ?>
					<input type="text" name="song" class="textbox" value="<?php echo $survey['favsong'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<input type="submit" />&nbsp;
				<input type="reset" />
			</div>
		</form>
	</div>
</body>
</html>