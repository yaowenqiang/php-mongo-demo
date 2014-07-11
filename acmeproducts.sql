-- create database acmeproducts;
use acmeproducts;
CREATE TABLE `customers` (
    `id` int(11) not null auto_increment,
    `first_name` varchar(256) not null,
    `last_name` varchar(256) not null,
    `email_address` varchar(255)  default null,
    `created_at` timestamp not null default CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email_address` (`email_address`)
) ENGINE = InnoDB;
CREATE TABLE `products`(
    `id` int(11) NOT NULL auto_increment,
    `name` varchar(255) NOT NULL,
    `unit_price` DOUBLE NOT NULL,
    `created_at` timestamp not null default CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
)ENGINE=InnoDB;
create TABLE `sales` (
    `id` int(11) NOT NULL auto_increment,
    `product_id` int(11) NOT NULL,
    `customer_id` int(11) NOT NULL,
    `units_sold` int(11) NOT NULL,
    `time_of_sales` timestamp NOT NULL default CURRENT_TIMESTAMP,
    PRIMARY KEY(`id`),
    KEY `sales_ibfk_1` (`product_id`),
    KEY `sales_ibfk_2` (`customer_id`)
) ENGINE=InnoDB;
-- ALTER TABLE `sales`
    -- ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`)
        -- REFERENCES `products` (`id`),
    -- ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer_id`)
        -- REFERENCES `customers` (`id`);
