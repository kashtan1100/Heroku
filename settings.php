<?php
define('MYSQL_SERVER','localhost');
define('MYSQL_USER','u1037497_default');
define('MYSQL_PASSWORD','akONVd2_');
define('MYSQL_BD','u1037497_default');

function db_connect(){
    $connect = mysqli_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD,MYSQL_BD)
        or die("Error " . mysqli_error($connect));
    if(!mysqli_set_charset($connect, "utf8")){
        print ("Error: ".mysqli_error($connect));
    }
    return $connect;
}

$connect = db_connect();