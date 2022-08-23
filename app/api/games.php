<?php

$method = $_SERVER['REQUEST_METHOD']; 
if ($method === 'GET') {
    header('Content-type: application/json; charset=utf-8');

    require $_SERVER['DOCUMENT_ROOT'].'/php/connect.php';
    
    $response = array();
    $data = array();
    $filter = 1;
    $columns = "*";

    if (isset($_GET["id"])) $filter = "id IN (".$_GET["id"].")";
    else if (isset($_GET["name"])) $filter = "name LIKE '%". $_GET["name"] ."%'";

    if (isset($_GET["keys"])) {
        // get Users columns
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Games' AND TABLE_SCHEMA = '$db_name'";
        $result = mysqli_query($conn, $query);
        $usersColumns = array();
        while($row = mysqli_fetch_assoc($result)) {
            $usersColumns[] = $row["COLUMN_NAME"];
        }

        // only keep columns that are from Users
        $columns = join(",", array_intersect($usersColumns, explode(",", $_GET["keys"])));
    }

    $userGamesAssoc = array();
    $userIds = array();
    $users = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"users"))) {
        // get user<->games association
        $query = "SELECT * FROM UserGames";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $userGamesAssoc[$row["gameId"]][] = $row["userId"];
            $userIds[] = $row["userId"];
        }

        // get users info from the users that matter
        $query = "SELECT * FROM Users WHERE id IN (" . join(",", $userIds) . ")";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $users[$row["id"]] = $row;
        }
    }
    
    $streams = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"streams"))) {
        // get users info from the users that matter
        $query = "SELECT * FROM Streams";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $streams[$row["gameId"]][] = $row;
        }
    }


	if (!str_contains($columns, "id")) $columns = $columns.($columns != "" ? "," : "")."id";

	$query = "SELECT ". $columns ." FROM Games WHERE ". $filter;
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($result)) {
	    if (isset($userGamesAssoc[$row["id"]])) {
            foreach($userGamesAssoc[$row["id"]] as $userId) {
                $row["users"][] = $users[$userId];
            }
	    }
			
	    $row["streams"] = (count($streams) > 0 && $streams[$row["id"]]) ? count($streams[$row["id"]]) : 0;

	    $data[] = $row;
	} 
    
    $response["data"] = $data;
    $response["size"] = count($data);
    date_default_timezone_set("Europe/Lisbon");
    $response["timestamp"] = date('Y-m-d H:i:s');
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
