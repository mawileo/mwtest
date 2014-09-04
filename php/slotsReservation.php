<?php
require_once('PersistentParkingPlace.php');
require_once('Authenticator.php');

$dbacc = new PersistentParkingPlace();
$auth = new Authenticator();


if ( $_SERVER["CONTENT_LENGTH"] > 1024 ) {
	http_response_code(400);
	exit;
}


$post_data_string = file_get_contents("php://input");
$post_data_structure = json_decode($post_data_string, true);

#var_dump($post_data_structure);

if ( !isset($post_data_structure["from"]) || !isset($post_data_structure["to"]) || !isset($post_data_structure["user"]) ) {
	http_response_code(400);
	echo "no expected parameters";
	exit;
}

$usr = $auth->getAuthenticatedUser();
if ( !$usr || $usr!=$post_data_structure["user"] ) {
	http_response_code(401);
	echo "bad credentials";
	exit;
}

$dbacc->makeReservation($post_data_structure["from"],$post_data_structure["to"],$usr);


echo "\n";

