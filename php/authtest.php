<?php
#header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Text to send if user hits Cancel button\n";
	echo ('REQUEST_URI: '.$_SERVER['REQUEST_URI']."\n");
	echo ('PHP_AUTH_USER: '.$_SERVER['PHP_AUTH_USER']."\n");
	echo ('PHP_AUTH_PW: '.$_SERVER['PHP_AUTH_PW']."\n");
    exit;

