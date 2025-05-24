<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'archerst_user1');
define('DB_PASS', 'password@user1');
define('DB_NAME', 'archerst_ScoreVault');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}