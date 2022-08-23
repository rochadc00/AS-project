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
    else if (isset($_GET["username"])) $filter = "username LIKE '%". $_GET["username"] ."%'";
    else if (isset($_GET["email"])) $filter = "email LIKE '%". $_GET["email"] ."%'";
    
    if (isset($_GET["streamer"])) $filter = $filter . " AND streamer = '". ($_GET["streamer"] == "true" ? "1" : "0") ."'";

    if (isset($_GET["keys"])) {
        // get Users columns
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Users' AND TABLE_SCHEMA = '$db_name'";
        $result = mysqli_query($conn, $query);
        $usersColumns = array();
        while($row = mysqli_fetch_assoc($result)) {
        	$usersColumns[] = $row["COLUMN_NAME"];
        }

        // only keep columns that are from Users
        $columns = join(",", array_intersect($usersColumns, explode(",", $_GET["keys"])));
    }
  
    $userGamesAssoc = array();
    $gameIds = array();
    $games = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"games"))) {
        // get user<->games association
        $query = "SELECT * FROM UserGames";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $userGamesAssoc[$row["userId"]][] = $row["gameId"];
            $gameIds[] = $row["gameId"];
        }

        // get games info from the games that matter
        $query = "SELECT * FROM Games WHERE id IN (" . join(",", $gameIds) . ")";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $games[$row["id"]] = $row;
        }
    }

    $tickets = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"tickets"))) {
        // get all ticket ids
        $query = "SELECT userId,id,ticketType FROM Tickets";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $tickets[$row["userId"]][$row["ticketType"]] = $row["id"];
        }
    }

    $favorites = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"favoriteGames"))) {
        // get all favorite games
        $query = "SELECT userId,gameId FROM UserFavoriteGames";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $favorites[$row["userId"]][] = $row["gameId"];
        }
    }

	if (!str_contains($columns, "id")) $columns = $columns.($columns != "" ? "," : "")."id";
	
    $query = "SELECT ". $columns ."  FROM Users WHERE ". $filter;
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        if (isset($row["streamer"]))    
            $row["streamer"] = $row["streamer"] == "1";

        if (isset($userGamesAssoc[$row["id"]])) {
            foreach($userGamesAssoc[$row["id"]] as $gameId) {
                $row["games"][] = $games[$gameId];
            }
        }

        $row["tickets"] = array();
        if (isset($tickets[$row["id"]]))
            $row["tickets"] = $tickets[$row["id"]];

        $row["favoriteGames"] = array();
        if (isset($favorites[$row["id"]]))
            $row["favoriteGames"] = $favorites[$row["id"]];

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
    if ($_GET["mode"] == "favorite") {
        if (isset($newData["userId"]) && isset($newData["gameId"])) {
            if ($_GET["action"] == "add")
                $query = "INSERT INTO UserFavoriteGames (userId, gameId) VALUES ('".$newData["userId"]."', '".$newData["gameId"]."');";

            else if ($_GET["action"] == "delete")
                $query = "DELETE FROM UserFavoriteGames WHERE userId = '".$newData["userId"]."' AND gameId = '".$newData["gameId"]."';";
            
            $result = mysqli_query($conn, $query);
        }
    }
    else if ($_GET["mode"] == "balance") {
    	if (isset($newData["id"])) {
    		if (isset($newData["money"])) {
					$query = "UPDATE Users SET money='".$newData["money"]."' WHERE id = '".$newData["id"]."'";
          $result = mysqli_query($conn, $query);
    		}
    	
    	  if (isset($newData["points"])) {
    			$query = "UPDATE Users SET points='".$newData["points"]."' WHERE id = '".$newData["id"]."'";
          $result = mysqli_query($conn, $query);
    		}
    	}
    }
}
