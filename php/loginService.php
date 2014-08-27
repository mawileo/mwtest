<?php
#header('WWW-Authenticate: Basic realm="My Realm"');
#echo ($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']."\n");
#exit;

require_once('Authenticator.php');

$auth = new Authenticator();
echo $auth->getAuthenticatedUser();

