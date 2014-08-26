<?php
#header('WWW-Authenticate: Basic realm="My Realm"');

#echo ($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']."\n");

if( $_SERVER['PHP_AUTH_USER'] === 'usr1' && $_SERVER['PHP_AUTH_PW'] === 'pwd1' ) {
	echo('usr1');
} elseif( $_SERVER['PHP_AUTH_USER'] === 'usr2' && $_SERVER['PHP_AUTH_PW'] === 'pwd2' ) {
	echo('usr2');
} else {
	echo('');
}
exit;

