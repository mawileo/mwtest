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

$usr = $auth->getAuthenticatedUser();

if ( !$usr ) {
	http_response_code(401);
	echo "bad credentials";
	exit;
}

foreach($post_data_structure as $range) {
	if ( !isset($range["from"]) || !isset($range["to"]) || !isset($range["user"]) ) {
		http_response_code(400);
		echo "wrong parameters: \n".$post_data_string;
		exit;
	}
	if ( $usr!=$range["user"] ) {
		http_response_code(401);
		echo "user unauthorized";
		exit;
	}
}

#$dbacc->makeReservation($post_data_structure["from"],$post_data_structure["to"],$usr);
$dbacc->makeReservation($post_data_structure);


echo "\n";

