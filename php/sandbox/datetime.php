<?php
#echo unixtojd(123456);

$year=2014;
$month=8;
$day=31;
$hour=13;
$minute=15;

$dt = new DateTime(null, new DateTimeZone("UTC"));
echo $dt->format("Y-m-d H:i:s")." / ".$dt->getTimestamp()."\n";

$hr = $dt->format("G"); # 24-hour hour without leading zero
$mnt = $dt->format("i");
$mnt = 15*floor($mnt/15);
#$dt->setDate($year, $month, $day);
$dt->setTime($hr,$mnt);

echo $dt->format("Y-m-d H:i:s")." / ".$dt->getTimestamp()."\n";


echo "MW\n\n";

