<?php
require 'vendor/autoload.php';
require 'blog/session_handler/mysql.php';
$mysql = getMySQLConnection();
$faker = Faker\Factory::create();

//generate data by accessing properties

//for ($i = 0; $i < 10000; $i++) {
    //$firstName  = $faker->name;
    //$lasttName  = $faker->name;
    //$email  = $faker->email;
    //$query = "insert into customers(first_name,last_name,email_address) values('$firstName','$lasttName','$email')";
    //$mysql->query($query);
//}

//for ($i = 0; $i < 10000; $i++) {
    //$name  = $faker->name;
    //$unit_price  = $faker->numberBetween(1,10000);
    //$query = "insert into products(name,unit_price) values('$name','$unit_price')";
    //$mysql->query($query);
//}
for ($i = 0; $i < 10000; $i++) {
    $customer_id  = $faker->numberBetween(1,10000);
    $product_id  = $faker->numberBetween(1,10000);
    $units_sold  = $faker->numberBetween(1,10000);
    $date  = (array)$faker->dateTimeThisMonth();
    $time_of_sales = $date['date'];
    $query = "insert into sales(product_id,customer_id,units_sold,time_of_sales) values('$customer_id','$product_id','$units_sold','$time_of_sales')";
    $mysql->query($query);
}
