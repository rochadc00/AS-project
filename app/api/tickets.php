<?php

require $_SERVER['DOCUMENT_ROOT'].'/php/connect.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    header('Content-type: application/json; charset=utf-8');
    
    $response = array();
    $data = array();
    $filter = 1;
    $columns = "*";

    if (isset($_GET["id"])) $filter = "id = '".$_GET["id"]."'";
    else if (isset($_GET["userId"])) $filter = "userId = '".$_GET["userId"]."'";

    if (isset($_GET["ticketType"])) $filter = $filter . " AND ticketType LIKE '%". $_GET["ticketType"] ."%'";

    if (isset($_GET["keys"])) {
        // get Tickets columns
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Tickets' AND TABLE_SCHEMA = '$db_name'";
        $result = mysqli_query($conn, $query);
        $ticketsColumns = array();
        while($row = mysqli_fetch_assoc($result)) {
            $ticketsColumns[] = $row["COLUMN_NAME"];
        }

        // only keep columns that are from Tickets
        $columns = join(",", array_intersect($ticketsColumns, explode(",", $_GET["keys"])));
    }

    $users = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"user"))) {
        // get users
        $query = "SELECT * FROM Users";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $users[$row["id"]] = $row;
        }
    }

    $ticketBetsAssoc = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"bets"))) {
        // get ticker<->bets association
        $query = "SELECT * FROM TicketBets";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $ticketBetsAssoc[$row["ticketId"]][] = $row["betId"];
        }
    }

	if (!str_contains($columns, "id")) $columns = $columns.($columns != "" ? "," : "")."id";

    if (count($users) > 0 && str_contains($_GET["keys"],"user")) $columns = $columns .",userId";

	$query = "SELECT ". $columns ." FROM Tickets WHERE ". $filter;
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($result)) {
	    if (count($users) > 0) {
            $row["user"] = $users[$row["userId"]];
	    }

        $row["bets"] = array();
        if (isset($ticketBetsAssoc[$row["id"]]))
            $row["bets"] = $ticketBetsAssoc[$row["id"]];
			
	    $data[] = $row;
	} 
    
    $response["data"] = $data;
    $response["size"] = count($data);
    date_default_timezone_set("Europe/Lisbon");
    $response["timestamp"] = date('Y-m-d H:i:s');
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
else if ($method === 'POST') {
    $newData = json_decode(file_get_contents('php://input'), true);
    if ($_GET["mode"] == "update") {
        if ($newData["id"]) {
            $unmutableKeys = array("userId", "ticketType", "id");
    
            // get Tickets columns
            $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Tickets' AND TABLE_SCHEMA = '$db_name'";
            $result = mysqli_query($conn, $query);
            $ticketsColumns = array();
            while($row = mysqli_fetch_assoc($result)) {
                $ticketsColumns[] = $row["COLUMN_NAME"];
            }
    
            foreach($newData as $key => $value) {
                if (in_array($key, $ticketsColumns) && !in_array($key, $unmutableKeys)) {
                    $query = "UPDATE Tickets SET ".$key." = '".$value."' WHERE id = '".$newData["id"]."'";
                    $result = mysqli_query($conn, $query);
                }
            }
        }
    }
    else if ($_GET["mode"] == "delete") {
        if ($newData["id"]) {
            // remove bets related to that ticket
            $query = "DELETE FROM TicketBets WHERE ticketId = '".$newData["id"]."'";   
            $result = mysqli_query($conn, $query);
             
            // reset ticket
            $query = "UPDATE Tickets SET odds='0', ticketValue='10', wins='0' WHERE id = '".$newData["id"]."'";
            $result = mysqli_query($conn, $query);
        }
    }
    else if ($_GET["mode"] == "increase") {
        // check if it exists
        $query = "SELECT * FROM TicketBets WHERE betID = '".$newData["betId"]."' AND ticketId = '".$newData["ticketId"]."';";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0) {
            if ($newData["betId"] && $newData["ticketId"]) {
                $query = "INSERT INTO TicketBets (betId, ticketId) VALUES ('".$newData["betId"]."', '".$newData["ticketId"]."');";
                $result = mysqli_query($conn, $query);
            }
        }
    }
    else if ($_GET["mode"] == "decrease") {
        if ($newData["betId"] && $newData["ticketId"]) {
            $query = "DELETE FROM TicketBets WHERE betID = '".$newData["betId"]."' AND ticketId = '".$newData["ticketId"]."';";
            $result = mysqli_query($conn, $query);
        }
    }
    else if ($_GET["mode"] == "register") {
    	if (isset($newData["userId"]) && isset($newData["ticketType"]) && isset($newData["odds"]) && isset($newData["ticketValue"]) && isset($newData["wins"]) && isset($newData["bets"])) {
				// add new registered ticket
				$query = "INSERT INTO RegisteredTickets (userId, ticketType, odds, ticketValue, wins) VALUES ('".$newData["userId"]."', '".$newData["ticketType"]."', '".$newData["odds"]."', '".$newData["ticketValue"]."', '".$newData["wins"]."');";				
				$result = mysqli_query($conn, $query);

				$query = "SELECT id FROM RegisteredTickets ORDER BY id DESC LIMIT 1;";
				$result = mysqli_query($conn, $query);
				$ticketId = mysqli_fetch_assoc($result)["id"];
	
				forEach($newData["bets"] as $bet) {
					// add bets to registered ticket
		      $query = "INSERT INTO RegisteredTicketBets (betId, ticketId) VALUES ('".$bet."', '".$ticketId."');";
					$result = mysqli_query($conn, $query);
				}
    	}
    }
}
