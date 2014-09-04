<?php
require_once('Reservable.php');
require_once('Slot.php');
#// mysqli
#$mysqli = new mysqli("example.com", "user", "password", "database");
#$result = $mysqli->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
#$row = $result->fetch_assoc();
#echo htmlentities($row['_message']);

class PersistentParkingPlace implements Reservable {

#	public function getCurrentSchedule() {


#		$mysqli = new mysqli("127.0.0.1", "innowo_mwtestusr", "innowo_mwtestusrpwd", "innowo_mwtestdb");
#		$result = $mysqli->query("SELECT id, name, usr FROM mwt_slots");

#		$r = array();

#		while ($row = $result->fetch_assoc()) {
#		# echo json_encode($row);
#			if($row["usr"]) {
#				$row["free"]=false;
#			} else {
#				$row["free"]=true;
#			}
#			array_push($r, $row);
#		    }

#		return $r;
#	}


	public function getCurrentSchedule() {

		$dts = new DateTime(null, new DateTimeZone("Europe/Zurich"));
		$dte = new DateTime(null, new DateTimeZone("Europe/Zurich"));
		$dte->setTimestamp($dts->getTimestamp());
		$dte->add(new DateInterval("P1D"));		

		$arr = array();

		foreach( $this->getSchedule($dts, $dte) as $slot ) {
			array_push($arr, $slot->toAssociativeArray());
		}
		return $arr;
	}

	private function getSchedule(DateTime $startDateTime, DateTime $endDateTime) {

		$startSlotId = Slot::dateTimeToSlotId($startDateTime);
		$endSlotId = Slot::dateTimeToSlotId($endDateTime);

		$slotsFromDb = $this->getTimeSlotsFromDb($startSlotId, $endSlotId);

		$arr = array();
		
		for($slot=$startSlotId; $slot<=$endSlotId; $slot=Slot::getNextSlotId($slot)) {
			if(isset($slotsFromDb[$slot]))  {
 				$arr[$slot] = $slotsFromDb[$slot];
			} else {
				$newSlot = new Slot("Europe/Zurich");
				$newSlot->setId($slot);
				$arr[$slot] = $newSlot;
			}
		}
		return $arr;
	}


	private function getTimeSlotsFromDb($startSlotId, $endSlotId) {


		$mysqli = new mysqli("127.0.0.1", "innowo_mwtestusr", "innowo_mwtestusrpwd", "innowo_mwtestdb");
		$result = $mysqli->query("SELECT id, name, usr FROM mwt_slots WHERE id between ".$startSlotId." and ".$endSlotId." order by id");

		$arr = array();


		if($result) while ($row = $result->fetch_assoc()) {
			$s = new Slot("Europe/Zurich");
			$s->setId($row["id"]);
			$s->setUser($row["usr"]);
			$arr[$s->getId()]=$s;
		    }

		return $arr;
	}

	public function makeReservation($fromDateTimeString, $toDateTimeString, $user) {
		$dt = DateTime::createFromFormat("Y-m-d G:i:s", $fromDateTimeString, new DateTimeZOne("Europe/Zurich"));
		$fromSlot = Slot::dateTimeToSlotId($dt);
		$dt = DateTime::createFromFormat("Y-m-d G:i:s", $toDateTimeString, new DateTimeZOne("Europe/Zurich"));
		$toSlot = Slot::dateTimeToSlotId($dt);
		if($fromSlot>$toSlot) {
			http_response_code(400);
			exit;
		}
		$this->reserveSlots($fromSlot, $toSlot, $user);
	}
	
	private function reserveSlots($startSlotId, $endSlotId, $user) {

		$mysqli = new mysqli("127.0.0.1", "innowo_mwtestusr", "innowo_mwtestusrpwd", "innowo_mwtestdb");
		$mysqli->autocommit(FALSE);

		$result = $mysqli->query("SELECT id, name, usr FROM mwt_slots WHERE id between ".$startSlotId." and ".$endSlotId." and usr is not null order by id");
		
		if(!$result) {
			print("Query failed\n");
			$mysqli->rollback();
			exit();
		}

		if($result->num_rows > 0) {
			print("Some slots are not free\n");
			$mysqli->rollback();
			exit();
		}

		$result = $mysqli->query("SELECT id, name, usr FROM mwt_slots WHERE id between ".$startSlotId." and ".$endSlotId." and usr is null order by id");
		if(!$result) {
			print("Query failed\n");
			$mysqli->rollback();
			exit();
		}
		$existingSlotIDs = array();
		while ($row = $result->fetch_assoc()) {
			$existingSlotIDs[$row["id"]]=$row["id"];
		}

		for($slot=$startSlotId; $slot<=$endSlotId; $slot=Slot::getNextSlotId($slot)) {
			if(isset($existingSlotIDs[$slot]))  {
				if( ! $mysqli->query("UPDATE mwt_slots SET usr = '".$user."'") ) {
					print("Update failed\n");
					$mysqli->rollback();
					exit();
				} 				
			} else {
				if( ! $mysqli->query("INSERT INTO mwt_slots (id, name, usr) VALUES (".$slot.",'NM','".$user."')") ) {
					print("Insert failed\n");
					$mysqli->rollback();
					exit();
				} 				
			}
		}

		if (!$mysqli->commit()) {
			print("Transaction commit failed\n");
			exit();
		}

	}
	
}

#$ppp = new PersistentParkingPlace();
#echo (json_encode($ppp->getCurrentSchedule()))."\n";

