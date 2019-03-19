<?php
    session_start();

    $mysqli = new mysqli("localhost","root", "root", "legoblog2");

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
                exit();
    }

    define('ROOT_PATH', realpath(dirname(__FILE__)));
    define('BASE_URL', 'http://localhost/legoblog2/');
?>