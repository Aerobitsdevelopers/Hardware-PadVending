<?php
    define('BASE_PATH','http://localhost/api_padvending/');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'api_padvending');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    // define('DB_USER','padVending');
    // define('DB_PASSWORD','U7n(QIER737.');
    
    date_default_timezone_set("Asia/Kolkata");
    $mysqli=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    header("Access-Control-Allow-Origin: http://0.0.0.0:5000");
    header("Access-Control-Allow-Methods: GET");
?>