<?php
require_once('slots.php');
require_once('reservable.php');
require_once('dbaccess.php');

$dbacc = new PersistentParkingPlace();

$slots = new Slots($dbacc);
echo $slots->getSlotMap();
echo "
";

