<?php

class Slot {

	private $id;
	private $usr;

	private $tmpdt;
	const slotLengthInMinutes = 15;

#	function __construct(DateTime $dt) {
#		$this->id = $this->dateTimeToSlotId($dt);
#		$this->tmpdt = new DateTime(null, new DateTimeZone("UTC"));
#	}

	function __construct($timeZone) {
		$this->tmpdt = new DateTime(null, new DateTimeZone($timeZone));
		$this->slotLengthInMinutes = 15;
	}

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;	
	}

	function getUser() {
		return $this->usr;
	}

	function setUser($usr) {
		$this->usr = $usr;	
	}

	function getYear() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("Y");
	}

	function getMonth() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("m");
	}

	function getDay() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("d");
	}

	function getHour() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("H");
	}

	function getMinute() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("i");
	}
	
	function getTimezone() {
		return $this->tmpdt->getTimezone()->getName();
	}
	
	function isFree() {
		return ($this->usr)==null;
	}

	function toAssociativeArray() {
		return array(
			"id" => $this->id,
			"timezone" => $this->getTimezone(),
			"year" => $this->getYear(),
			"month" => $this->getMonth(),
			"day" => $this->getDay(),
			"hour" => $this->getHour(),
			"minute" => $this->getMinute(),
			"usr" => $this->usr,
			"free" => $this->isFree(),
			"name" => "NM"
			);
	}

	public static function dateTimeToSlotId(DateTime $dt) {

		$utcDt = new DateTime(null, new DateTimeZone("UTC"));
		$utcDt->setTimestamp($dt->getTimestamp());
		$hr = $utcDt->format("G"); # 24-hour hour without leading zero
		$mnt = $utcDt->format("i");
		$mnt = (Slot::slotLengthInMinutes)*floor($mnt/(Slot::slotLengthInMinutes)); # round down to slot length minut granularity
		$utcDt->setTime($hr,$mnt);
		return (integer) ( $utcDt->getTimestamp() );
	}

	public static function getNextSlotId($slotId) {
		$utcDt = new DateTime(null, new DateTimeZone("UTC"));
		$utcDt->setTimestamp($slotId);
		$utcDt->add(new DateInterval("PT".(Slot::slotLengthInMinutes)."M"));
		return (integer) ( $utcDt->getTimestamp() );
	}

	
}


#$dtutc = new DateTime(null, new DateTimeZone("UTC"));
#$dtzurich = new DateTime(null, new DateTimeZone("Europe/Zurich"));
#echo $dtutc->format("Y-m-d H:i:s")." ".Slot::dateTimeToSlotId($dtutc)."\n";
#echo $dtzurich->format("Y-m-d H:i:s")." ".Slot::dateTimeToSlotId($dtzurich)."\n";
#echo "Next slot Id: ".Slot::getNextSlotId(Slot::dateTimeToSlotId($dtzurich))."\n";

#$s2 = new Slot("UTC");
#$s2->setId(Slot::dateTimeToSlotId($dtzurich));
#echo json_encode(($s2->toAssociativeArray()))."\n";

#$s = new Slot("Europe/Zurich");
#$s->setId(Slot::dateTimeToSlotId($dtzurich));
#echo json_encode(($s->toAssociativeArray()))."\n";

