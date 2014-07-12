<?php
require 'mysql.php';
require 'dbconnection.php';
$cutoffDate = date('Y-m-d',strtotime('+30 day'));
$mysql = getMySQLConnection();
//get all the sales records older then one month;
$query = sprintf('SELECT * FROM sales WHERE DATE(time_of_sales) < "%s"',$cutoffDate);
printf("Fetching old data from MySQL...\n");
$result = $mysql->query($query);
if ($result === False) {
    die(sprintf('Error execuging query %s',$mysql->error));
}
printf("Migratiing to MongoDB...\n");
$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('sales_archive');
while ($record = $result->FETCH_ASSOC()) {
    try {
        $collection->insert($record,array('safe'=>True));
    } catch (MongoCursorException $e) {
        die('Migrating Failed '.$e->getMessage());
    }
}
printf("\t Done.%d records migrated.\n",$result->num_rows);
$result->free();
printf("Deleting old data from MySQL...\n");
$query = sprintf("DELETE FROM sales where DATE(time_of_sales) < '%s'",$cutoffDate);
$status = $mysql->query($query);
if ($status === False) {
    die(sprintf("Error executing query %s",$mysql->error));
}
$mysql->close();
printf("Archiving complete.\n");
