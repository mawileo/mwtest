<?php
require_once('Slots.php');
require_once('Reservable.php');
require_once('PersistentParkingPlace.php');

require_once('AuthenticationService.php');
require_once('Authenticator.php');

$dbacc = new PersistentParkingPlace();
$slots = new Slots($dbacc);

$auth = new Authenticator();

echo $slots->getSlotMap($auth->getAuthenticatedUser());
echo "
";

