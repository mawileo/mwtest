<?php
require_once('slots.php');
require_once('reservable.php');
require_once('dbaccess.php');

require_once('AuthenticationService.php');
require_once('Authenticator.php');

$dbacc = new PersistentParkingPlace();
$slots = new Slots($dbacc);

$auth = new Authenticator();

echo $slots->getSlotMap($auth->getAuthenticatedUser());
echo "
";

