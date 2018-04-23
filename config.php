<?php

// Connecting to the MySQL database
$user = 'dinhh2';
$password = 'tUC5Vasa';

$database = new PDO('mysql:host=localhost;dbname=db_spring18_dinhh2', $user, $password);

// include functions
include('functions.php');

function my_autoloader($class) {
    include 'classes/class.' . $class . '.php';
}

spl_autoload_register('my_autoloader');

// Start the session
session_start();

if (!isset($_SESSION['queue'])) {
	$_SESSION['queue'] = new Queue();
}