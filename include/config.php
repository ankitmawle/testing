<?php

    //database configuration
    $host       = "localhost";
    $user       = "rootgq8v_BattleTournament";
    $pass       = "@#Vipulsingh";
    $database   = "rootgq8v_BattleTournament";

    $connect = new mysqli($host, $user, $pass, $database);

    if (!$connect) {
        die ("connection failed: " . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8');
    }
	
	$GLOBALS['config'] = $connect;


    $ENABLE_RTL_MODE = 'false';

?>