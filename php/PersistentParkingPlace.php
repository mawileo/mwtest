<?php
require_once('Reservable.php');
#// mysqli
#$mysqli = new mysqli("example.com", "user", "password", "database");
#$result = $mysqli->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
#$row = $result->fetch_assoc();
#echo htmlentities($row['_message']);

class PersistentParkingPlace implements Reservable {

	public function getCurrentSchedule() {


		$mysqli = new mysqli("127.0.0.1", "innowo_mwtestusr", "innowo_mwtestusrpwd", "innowo_mwtestdb");
		$result = $mysqli->query("SELECT id, name, usr FROM mwt_slots");

		$r = array();

		while ($row = $result->fetch_assoc()) {
		# echo json_encode($row);
			if($row["usr"]) {
				$row["free"]=false;
			} else {
				$row["free"]=true;
			}
			array_push($r, $row);
		    }

		return $r;
#		echo json_encode($r);
#		echo "
#		";

		#$row = $result->fetch_assoc();
		#echo htmlentities($row['_message']);
	}
}
