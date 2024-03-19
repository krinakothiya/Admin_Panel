<?php

$servername = "localhost";
$username = "root";
$pasword = "";
$db_name = "test";

$conn = new mysqli($servername, $username, $pasword, $db_name);
if ($conn->connect_error) {
    die("connection is fail");
}
echo "";
