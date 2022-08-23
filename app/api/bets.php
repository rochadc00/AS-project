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

    if (isset($_GET["betGroup"])) $filter = $filter . " AND betGroup = '".$_GET["betGroup"]."'";

    if (isset($_GET["resultType"])) $filter = $filter . " AND resultType = '".$_GET["resultType"]."'";
    
    if (isset($_GET["resultTeam"])) $filter = $filter . " AND resultTeam LIKE '%". $_GET["resultTeam"] ."%'";

    if (isset($_GET["keys"])) {
        // get Users columns
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Bets' AND TABLE_SCHEMA = '$db_name'";
        $result = mysqli_query($conn, $query);
        $usersColumns = array();
        while($row = mysqli_fetch_assoc($result)) {
            $usersColumns[] = $row["COLUMN_NAME"];
        }

        // only keep columns that are from Users
        $columns = join(",", array_intersect($usersColumns, explode(",", $_GET["keys"])));
    }

    $streams = array();
    if (!isset($_GET["keys"]) || (isset($_GET["keys"]) && str_contains($_GET["keys"],"stream"))) {
        // get all streams
        $query = "SELECT * FROM Streams";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $streams[$row["id"]] = $row;
        }
    }

	if (!str_contains($columns, "id")) $columns = $columns.($columns != "" ? "," : "")."id";

    if (count($streams) > 0 && str_contains($_GET["keys"],"stream")) $columns = $columns .",streamId";

	$query = "SELECT ". $columns ." FROM Bets WHERE ". $filter;
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($result)) {
	    if (count($streams) > 0)
            $row["stream"] = $streams[$row["streamId"]];

	    $data[] = $row;
	} 
    
    $response["data"] = $data;
    $response["size"] = count($data);
    date_default_timezone_set("Europe/Lisbon");
    $response["timestamp"] = date('Y-m-d H:i:s');
    echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
