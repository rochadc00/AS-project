<?php

$document_root=$_SERVER['DOCUMENT_ROOT'];

require $document_root.'/php/connect.php';
require $document_root.'/php/functions.php';

// setup data size variables
$size_sets = [
    "small" => [1, 7, 10],
    "medium" => [15, 20, 20],
    "large" => [25, 40, 30]
];

$data_size = isset($_GET["size"]) && array_key_exists($_GET["size"], $size_sets) ? $_GET["size"] : "small";
$min_games_per_user = $size_sets[$data_size][0];
$max_games_per_user = $size_sets[$data_size][1];
$max_streams_per_assoc = $size_sets[$data_size][2];
echo "Data set size: ". $data_size ."<br>";

// setup tables
$tables = array(
    "CREATE TABLE `gamebet`.`Users`(
        username VARCHAR(255) NOT NULL ,
        email VARCHAR(255) NOT NULL ,
        streamer BOOLEAN NOT NULL ,
        money VARCHAR(255) NOT NULL ,
        points VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`UserAuth`(
        email VARCHAR(255) NOT NULL ,
        pwd TEXT NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`Games`(
        name VARCHAR(255) NOT NULL ,
        cover TEXT NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`Streams`(
        title VARCHAR(255) NOT NULL ,
        thumbnail TEXT NOT NULL ,
        viewers TEXT NOT NULL ,
        gameId VARCHAR(255) NOT NULL ,
        userId VARCHAR(255) NOT NULL ,
        platform SET('Youtube','Twitch') NOT NULL ,
        matchFormat SET('Tournment','Casual') NOT NULL ,
        matchBeginning TIMESTAMP NOT NULL ,
        teamA VARCHAR(255) NOT NULL ,
        teamB VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`Bets`(
        streamId VARCHAR(255) NOT NULL ,
        betGroup VARCHAR(255) NOT NULL ,
        resultType VARCHAR(255) NOT NULL ,
        resultTeam VARCHAR(255) NOT NULL ,
        odd VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`UserGames`(
        userId VARCHAR(255) NOT NULL ,
        gameId VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`Tickets`(
        userId VARCHAR(255) NOT NULL ,
        ticketType SET('Simple','Multiple','Group') NOT NULL ,
        odds VARCHAR(255) NOT NULL ,
        ticketValue VARCHAR(255) NOT NULL ,
        wins VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`TicketBets`(
        betId VARCHAR(255) NOT NULL ,
        ticketId VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`UserFavoriteGames`(
        userId VARCHAR(255) NOT NULL ,
        gameId VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )",
    "CREATE TABLE `gamebet`.`RegisteredTickets`(
        userId VARCHAR(255) NOT NULL ,
 				ticketType SET('Simple','Multiple','Group') NOT NULL ,
        odds VARCHAR(255) NOT NULL ,
        ticketValue VARCHAR(255) NOT NULL ,
        wins VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `gamebet`.`RegisteredTicketBets`(
        betId VARCHAR(255) NOT NULL ,
        ticketId VARCHAR(255) NOT NULL ,
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    )"
);

echo "Adding tables:<br>";
foreach($tables as $table) {
    $table_name = explode("`", $table)[3];
    $result = mysqli_query($conn, "SHOW TABLES LIKE '". $table_name . "';");
    if (mysqli_num_rows($result) == 0) { 
        echo "- Creating table " . $table_name . "<br>";
        mysqli_query($conn, $table);
    }
}

// fill tables
require $document_root."/php/static-data.php";

// fill Users table
$result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM Users) as `row_exists`;");
if (mysqli_fetch_assoc($result)["row_exists"] == 0) { 
    echo "Adding fake Users data...<br>";
    forEach($usernames as $userId=>$username) {
        $streamer = rand(0,1);
        $email = strtolower($username) ."@fakemail.com";
        $sql = "INSERT INTO Users (email, streamer, username, money, points) VALUES ('".$email."', '".rand(0,1)."', '".$username."', '".rand(0,150)."', '".rand(0,2000)."');";
        mysqli_query($conn, $sql);

        // add credentials
        $pwd = "123456";
        $sql = "INSERT INTO UserAuth (email, pwd) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email, password_hash($pwd, PASSWORD_DEFAULT));
        mysqli_stmt_execute($stmt);

        // create empty ticket
        $defaultTicketPrice = 10;
        forEach(array("Simple", "Multiple", "Group") as $ticketType) {
            $sql = "INSERT INTO Tickets (userId, ticketType, odds, ticketValue, wins) VALUES ('".($userId+1)."', '".$ticketType."', '0', '".$defaultTicketPrice."', '0');";
            mysqli_query($conn, $sql);
        }
    }
}

// fill Games table
$result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM Games) as `row_exists`;");
if (mysqli_fetch_assoc($result)["row_exists"] == 0) { 
    echo "Adding fake Games data...<br>";
    forEach($games as $game) {
        $sql = "INSERT INTO Games (name, cover) VALUES ('".$game[1]."', '".$game[0]."');";
        mysqli_query($conn, $sql);
    }
}

// fill UserGames table
$result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM UserGames) as `row_exists`;");
if (mysqli_fetch_assoc($result)["row_exists"] == 0) {
    echo "Randomly matching Users to Games...<br>";
    // get all users ids that are streamers
    $usersIds = array_map(function ($elem) {
        return $elem["id"];
    }, apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=id&streamer=true")["data"]);
    // get all games ids
    $gamesIds = array_map(function ($elem) {
            return $elem["id"];
    }, apiFetch("http://".$_SERVER['SERVER_NAME']."/api/games?keys=id")["data"]);

    foreach($usersIds as $userId) {
        // get n random games
        $userGames = array_rand(array_flip($gamesIds), rand(1,7));
        $userGames = !is_array($userGames) ? array($userGames) : $userGames;
        foreach($userGames as $game) {
            $sql = "INSERT INTO UserGames (userId, gameId) VALUES ('".$userId."', '".$game."');";
            mysqli_query($conn, $sql);
        }
    }
}

// fill Streams table
$result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM Streams) as `row_exists`;");
if (mysqli_fetch_assoc($result)["row_exists"] == 0) { 
    echo "Adding fake Streams data...<br>";
    $platforms = array("Youtube", "Twitch");
    $matchFormats = array("Tournment", "Casual");
    $queryValues = array();

    $query = "SELECT userId,gameId FROM UserGames";
    $result = mysqli_query($conn, $query);
    $max_possible_streams = mysqli_num_rows($result)*5;

    // fetch lorem ipsum for titles from baconipsum.com
    $titles = array();
    for ($i = 0; $i < ceil($max_possible_streams/100); $i++) {
        $titles = array_merge($titles, explode(". ", apiFetch("https://baconipsum.com/api/?type=meat-and-filler&sentences=". $max_possible_streams)[0]));
    }
    shuffle($titles);
    date_default_timezone_set("Europe/Lisbon");
    $counter = 0;

    $query = "SELECT userId,gameId FROM UserGames";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
        // n streams from this user on this game
        $n_streams = rand(1, $max_streams_per_assoc);
        for ($i = 0; $i < $n_streams; $i++) {
            $title = array_pop($titles);
            $thumbnail = 'https://picsum.photos/300/170?random='.$counter++;
            $viewers = rand(100, 100000);
            $userId = $row["userId"];
            $gameId = $row["gameId"];
            $timeMultiplier = rand(0, 10);
            $timeOp = rand(0,1) == "0" ? "-" : "+";
            $beginning = date('Y-m-d H:i:s', strtotime(" ". $timeOp ." ". $timeMultiplier*10 ." minutes"));
            $queryValues[] = "('".$title."', '".$thumbnail."', '".$viewers."', '".$userId."', '".$gameId."', '".$platforms[rand(0,1)]."', '".$matchFormats[rand(0,1)]."', '".$beginning."', '".$teams[rand(0, count($teams)-1)]."', '".$teams[rand(0, count($teams)-1)]."')";
        }
    }
    $sql = "INSERT INTO Streams (title, thumbnail, viewers, userId, gameId, platform, matchFormat, matchBeginning, teamA, teamB) VALUES ". join(",", $queryValues) .";";
    mysqli_query($conn, $sql);
}

// fill Bets table
$result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM Bets) as `row_exists`;");
if (mysqli_fetch_assoc($result)["row_exists"] == 0) { 
    echo "Adding fake Bets data...<br>";
    // get all streams
    $streams = apiFetch("http://".$_SERVER['SERVER_NAME']."/api/streams?keys=id,teamA,teamB")["data"];

    $max_bets_per_stream = 12;
    $queryValues = array();
    foreach($streams as $stream) {
        $bets_this_stream = rand(6, $max_bets_per_stream);
        $teams = array($stream["teamA"], $stream["teamB"]);
        for($i = 0; $i < $bets_this_stream; $i++) {
            $odd = round(mt_rand() / mt_getrandmax() + rand(1, 10), 2);
            $queryValues[] = "('".$stream["id"]."', '".$betGroups[rand(0, count($betGroups)-1)]."', '".$betsResultTypes[rand(0, count($betsResultTypes)-1)]."', '".$teams[rand(0, count($teams)-1)]."', '".$odd."')";
        }
    }
    $sql = "INSERT INTO Bets (streamId, betGroup, resultType, resultTeam, odd) VALUES ". join(",", $queryValues) .";";
    mysqli_query($conn, $sql);
}
