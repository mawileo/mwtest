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
	
	function getSecond() {
		$this->tmpdt->setTimestamp($this->id);
		return $this->tmpdt->format("s");
	}

	function getSlotEndYear() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("Y");
	}

	function getSlotEndMonth() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("m");
	}

	function getSlotEndDay() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("d");
	}

	function getSlotEndHour() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("H");
	}

	function getSlotEndMinute() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("i");
	}
	
	function getSlotEndSecond() {
		$this->tmpdt->setTimestamp($this->getSlotsLastSecondTimestamp());
		return $this->tmpdt->format("s");
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
			"from" => $this->getYear()."-".$this->getMonth()."-".$this->getDay()." ".$this->getHour().":".$this->getMinute().":".$this->getSecond(),
			"to" => $this->getSlotEndYear()."-".$this->getSlotEndMonth()."-".$this->getSlotEndDay()." ".$this->getSlotEndHour().":".$this->getSlotEndMinute().":".$this->getSlotEndSecond(),
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

	public static function dateTimeStringToSlotId($dateTimeString) {
		$dt = DateTime::createFromFormat("Y-m-d G:i:s", $dateTimeString, new DateTimeZOne("Europe/Zurich"));
		$slotId = Slot::dateTimeToSlotId($dt);
		return $slotId;
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

	public function getSlotsLastSecondTimestamp() {
		$utcDt = new DateTime(null, new DateTimeZone("UTC"));
		$utcDt->setTimestamp($this->id);
		$utcDt->add(new DateInterval("PT".(Slot::slotLengthInMinutes)."M"));
		$utcDt->sub(new DateInterval("PT1S"));
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

