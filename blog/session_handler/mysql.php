<?php
define('MYSQL_HOST','localhost');
define('MYSQL_PORT','3306');
define('MYSQL_USER','root');
define('MYSQL_PASSWD','123456');
define('MYSQL_DBNAME','acmeproducts');
//function for connection to MySQL
function getMySQLConnection()
{
    $mysqli = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWD,MYSQL_DBNAME,MYSQL_PORT);
    if (mysqli_connect_error()) {
        die(sprint_f('Error connection to MySQL,Error No: %d,'.'Error: %s',mysqli_connect_errno,mysqli_connect_error()));
    }
    return $mysqli;
}
