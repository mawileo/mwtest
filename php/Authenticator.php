<?php
require_once('AuthenticationService.php');

class Authenticator implements AuthenticationService {

	public function getAuthenticatedUser() {
		if( $_SERVER['PHP_AUTH_USER'] === 'usr1' && $_SERVER['PHP_AUTH_PW'] === 'pwd1' ) {
			return 'usr1';
		} elseif( $_SERVER['PHP_AUTH_USER'] === 'usr2' && $_SERVER['PHP_AUTH_PW'] === 'pwd2' ) {
			return 'usr2';
		} else {
			return null;
		}
	}
}
