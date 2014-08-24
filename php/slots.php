<?php
require_once('reservable.php');

class Slots {

  private $reservable;

  function __construct($r) {
       $this->reservable = $r;
  }

  public function getSlotMap() {

	$reservation_info = $this->reservable->getCurrentSchedule();
	$this->annonymizeReservedBy($reservation_info);

	return json_encode(array("slots"=>$reservation_info));   

#	return '{"slots":[{"id":"1","name":"12:00","usr":null,"free":true},{"id":"2","name":"13:00","usr":null,"free":true},{"id":"3","name":"14:00","usr":"user01","free":false}]}';

#    return '{"slots":[{"id":"1","name":"12:00","usr":null,"free":true},{"id":"2","name":"13:00","usr":null,"free":true},{"id":"3","name":"14:00","usr":"user01","free":false}]}';


#    return
#      '
#	{ "slots" :
#	[
#	    { "name": "12:00", "free": true }, { "name": "13:00", "free": true }, { "name": "14:00", "free": false },
#	    { "name": "15:00", "free": true }, { "name": "Slot5", "free": true }, { "name": "Slot6", "free": true },
#	    { "name": "Slot7", "free": true }, { "name": "Slot8", "free": false }, { "name": "Slot9", "free": false }
#	]
#	}
#      ';
  }

  private function annonymizeReservedBy(&$reservation_info) {
	foreach($reservation_info as &$slot) {
		if($slot["usr"] !== "userme") {
			$slot["usr"] = null;
		}	
	}
  }

}

#echo '
#{ "slots" :
#[
#    { "name": "12:00", "free": true }, { "name": "13:00", "free": true }, { "name": "14:00", "free": false },
#    { "name": "Slot4", "free": true }, { "name": "Slot5", "free": true }, { "name": "Slot6", "free": true },
#    { "name": "Slot7", "free": true }, { "name": "Slot8", "free": false }, { "name": "Slot9", "free": false }
#]
#}
#';

