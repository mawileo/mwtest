<?php
#foreach ( $_SERVER as $key => $val ) {
#	echo "key: ".$key." value: ".$val."\n";
#}
#echo "\n***\n";

if ( $_SERVER["CONTENT_LENGTH"] > 1024 ) {
	http_response_code(400);
	exit;
}

$post_data_string = file_get_contents("php://input");
$post_data_structure = json_decode($post_data_string, true);

#var_dump($post_data_structure);

foreach( $post_data_structure["ranges"] as $range ) {
	echo "Range: ".$range["start"]."-".$range["end"]."\n";
}

echo "\n";

