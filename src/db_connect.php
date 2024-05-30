<?php
try{
    $dbHost = getenv('DB_HOST');
    $dbPort = getenv('DB_PORT');
    $dbName = getenv('DB_NAME');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASS');

    $dsn = "mysql:dbname=$dbName;host=$dbHost:$dbPort";
    $dbh = new PDO($dsn, $dbUser, $dbPass);
}catch(PDOException $e){
    echo 'DBに接続できませんでした。';
    echo $e->getMessage();
    exit();
}