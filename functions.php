<?php

function get($key) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	}
	
	else {
		return '';
	}
}

function findSongs($term, $database) {
	// Get list of songs
	$term = '%' . $term . '%';
	$sql = file_get_contents('sql/getSongs.sql');
	$params = array(
		'term' => $term
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$songs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $songs;
}