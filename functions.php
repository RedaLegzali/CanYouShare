<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

function upload($route) {
	$dir = (isset($_SESSION['team'])) ? $_SESSION['team'] : $_SESSION['admin'];
	$target_dir = ($route == 'upload') ? "uploads/" . $dir . '/' : "uploads/";
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

function shared() {
	$dir = 'uploads/';
	$directories = scandir($dir);
	$response = array();
	for($i=2; $i < count($directories); $i++) {
		if (substr($directories[$i], -4) == '.zip') {
			$link = $dir . $directories[$i];
			$directory = substr($directories[$i], 0, -4);
			array_push( $response, array("link" => $link, "name" => $directory) );
		}
	}
	echo json_encode($response);
}

function files() {
	$dir = (isset($_SESSION['team'])) ? $_SESSION['team'] : $_SESSION['admin'];
	$full_dir = 'uploads/' . $dir . '/';
	$directories = scandir($full_dir);
	$response = array();
	for($i=2; $i < count($directories); $i++) {
		$directory = substr($directories[$i], 0, -4);
		if (isset($_SESSION['admin'])) {
			$link = $full_dir . $directories[$i];
			array_push( $response, array("link" => $link, "name" => $directory) );
		}
		else {
			array_push( $response, array("name" => $directory) );
		}
	}
	echo json_encode($response);
}

function login($team, $password) {
	$data = array(
		"reda" => [ "team" => "group_reda", "admin" => "admin_reda" ],
		"samy" => [ "team" => "group_samy", "admin" => "admin_samy" ],
		"oumaima" => [ "team" => "group_oumaima", "admin" => "admin_oumaima" ],
		"hamza" => [ "team" => "group_hamza", "admin" => "admin_hamza" ]
	);
	$status = 0;
	if ( ! array_key_exists( $team, $data ) ) {
		$status = 1;
		$message = "Choose a Team";
	}
	else if ( $data[$team]["team"] == $password ) {
		$_SESSION['logged'] = true;
		$_SESSION['team'] = $team;
		$message = "Login Successful";
	}
	else if ( $data[$team]["admin"] == $password ) {
		$_SESSION['logged'] = true;
		$_SESSION['admin'] = $team;
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
	if ($_SERVER['REQUEST_URI'] == "/upload/shared" ) {
		upload('shared');
	}
	if ($_SERVER['REQUEST_URI'] == "/upload/upload" ) {
		upload('upload');
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
	if ($_SERVER['REQUEST_URI'] == "/shared" ) {
		shared();
	}
	if ($_SERVER['REQUEST_URI'] == "/logout" ) {
		logout();
	}
}


