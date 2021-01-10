<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'ID329156_matchme.db.webhosting.be');
define('DB_USERNAME', 'ID329156_matchme');
define('DB_PASSWORD', 'Welovethomasmore2021');
define('DB_NAME', 'ID329156_matchme');
$Hostname = "ID329156_matchme.db.webhosting.be";
$User_name = "ID329156_matchme";
$Password = "Welovethomasmore2021";
$Database = "ID329156_matchme";
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


function GetQuery($sql)
{
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $result = $link->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $link->close();
    return $rows;
}
