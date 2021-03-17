<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

function upload() {
	$target_dir = "uploads/" . $_SESSION['team'] . '/';
	$target_file = $target_dir . basename($_FILES["archive"]["name"]);
	$extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$status = 0;

	if ($extension != 'zip') {
		$status = 1;
		$message = "Wrong file type, only ZIP is allowed";
	}
	else if (file_exists($target_file)) {
		$status = 1;
		$message = "File already exists";
	}

	if ($status == 0) {
		if (move_uploaded_file($_FILES["archive"]["tmp_name"], $target_file)) {
			$message = "File uploaded successfully";
		}
		else {
			$status = 1;
			$message = "There was an error uploading the file";
		}
	}

	echo json_encode( array("status" => $status, "message" => $message) );
}

function files() {
	$dir = 'uploads/' . $_SESSION['team'] . '/';
	$directories = scandir($dir);
	$response = array();
	array_push( $response, array("link" => 'uploads/Cours.zip', "name" => 'Cours') );
	array_push( $response, array("link" => 'uploads/Labs.zip', "name" => 'Labs') );
	for($i=2; $i < count($directories); $i++) {
		$link = $dir . $directories[$i];
		$directory = substr($directories[$i], 0, -4);
		array_push( $response, array("link" => $link, "name" => $directory) );
	}
	echo json_encode($response);
}

function login($team, $password) {
	$data = array(
		"reda" => "group_reda",
		"samy" => "group_samy",
		"hamza" => "group_hamza",
		"oumaima" => "group_oumaima"
	);
	$status = 0;
	if ( ! array_key_exists( $team, $data ) ) {
		$status = 1;
		$message = "Choose a Team";
	}
	else if ( $data[$team] == $password ) {
		$_SESSION['logged'] = true;
		$_SESSION['team'] = $team;
		$message = "Login Successful";
	}
	else {
		$status = 1;
		$message = "Password Incorrect";
	}
	echo json_encode( array("status" => $status, "message" => $message) );
}

function logout() {
	session_destroy();
	  $redirection = 'Location: http://' . $_SERVER['HTTP_HOST'] . '/';
	  header($redirection);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SERVER['REQUEST_URI'] == "/upload" ) {
		upload();
	}
	if ($_SERVER['REQUEST_URI'] == "/auth" ) {
		$team = $_POST['team'];
		$password = $_POST['password'];
		login($team, $password);
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if ($_SERVER['REQUEST_URI'] == "/files" ) {
		files();
	}
	if ($_SERVER['REQUEST_URI'] == "/logout" ) {
		logout();
	}
}


