<?php

$method = $_SERVER['REQUEST_METHOD']; 
if ($method === 'GET') {
    header('Content-type: application/json; charset=utf-8');

    require $_SERVER['DOCUMENT_ROOT'].'/php/connect.php';
    
    $response = array();
    $data = array();
    $filter = 1;
    $columns = "*";

    if (isset($_GET["id"])) $filter = "id = '".$_GET["id"]."'";
    else if (isset($_GET["title"])) $filter = "title LIKE '%". $_GET["title"] ."%'";
    
    if (isset($_GET["game"])) $filter = $filter . " AND gameId = '".$_GET["game"]."'";

    if (isset($_GET["platform"])) $filter = $filter . " AND platform = '".$_GET["platform"]."'";
    
    if (isset($_GET["matchFormat"])) $filter = $filter . " AND matchFormat = '".$_GET["matchFormat"]."'";
    
    if (isset($_GET["gameId"])) $filter = $filter . " AND gameId = '".$_GET["gameId"]."'";
        
    if (isset($_GET["userId"])) $filter = $filter . " AND userId = '".$_GET["userId"]."'";

    if (isset($_GET["team"])) $filter = $filter . " AND (teamA LIKE '%".$_GET["team"]."%' OR teamB LIKE '%".$_GET["team"]."%')";
    
    if (isset($_GET["keys"])) {
        // get Users columns
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Streams' AND TABLE_SCHEMA = '$db_name'";
        $result = mysqli_query($conn, $query);
        $usersColumns = array();
        while($row = mysqli_fetch_assoc($result)) {
        	$usersColumns[] = $row["COLUMN_NAME"];
        }

        // only keep columns that are from Users
        $columns = join(",", array_intersect($usersColumns, explode(",", $_GET["keys"])));
    }

    $gameIds = array();
    $games = array();
    $userIds = array();
    $users = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && (str_contains($_GET["keys"],"user") || str_contains($_GET["keys"],"game")))) {
        // get user<->games association
        $query = "SELECT * FROM UserGames";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $gameIds[] = $row["gameId"];
            $userIds[] = $row["userId"];
        }

        // get games info from the games that matter
        $query = "SELECT * FROM Games WHERE id IN (" . join(",", $gameIds) . ")";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $games[$row["id"]] = $row;
        }

        // get users info from the users that matter
        $query = "SELECT * FROM Users WHERE id IN (" . join(",", $userIds) . ")";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $users[$row["id"]] = $row;
        }
    }

    $bets = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"bets"))) {
        // get bets
        $query = "SELECT streamId,id FROM Bets";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $bets[$row["streamId"]][] = $row["id"];
        }
    }

  
	if (!str_contains($columns, "id")) $columns = $columns.($columns != "" ? "," : "")."id";
	
    if (count($games) > 0 && str_contains($_GET["keys"],"game")) $columns = $columns .",gameId";
    if (count($users) > 0 && str_contains($_GET["keys"],"user")) $columns = $columns .",userId";

    $query = "SELECT ". $columns ."  FROM Streams WHERE ". $filter;
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        if (!isset($_GET["keys"]) || (count($games) > 0 && str_contains($_GET["keys"],"game")))
            $row["game"] = $games[$row["gameId"]];

        if (!isset($_GET["keys"]) || (count($users) > 0 && str_contains($_GET["keys"],"user")))
            $row["user"] = $users[$row["userId"]];

        $row["bets"] = array();
        if (isset($bets[$row["id"]]))
            $row["bets"] = $bets[$row["id"]];

        if (!isset($_GET["user"]) || (isset($_GET["user"]) && count($users) > 0 && stripos($row["user"]["username"], $_GET["user"]) !== false))
            $data[] = $row;
    }
    
    $response["data"] = $data;
    $response["size"] = count($data);
    date_default_timezone_set("Europe/Lisbon");
    $response["timestamp"] = date('Y-m-d H:i:s');
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
