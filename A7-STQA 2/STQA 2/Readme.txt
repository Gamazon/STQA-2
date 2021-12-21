create database healthshop;
GRANT ALL ON healthshop.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON healthshop.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

CREATE TABLE customer (
cust_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL,
email VARCHAR(128)NOT NULL UNIQUE,
pass VARCHAR(128) NOT NULL,
address VARCHAR(128) NOT NULL,
city VARCHAR(128),
state VARCHAR(128),
phoneno BIGINT NOT NULL UNIQUE,
pincode INTEGER
);

CREATE TABLE product (
prod_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(128) NOT NULL UNIQUE,
category CHAR(1) NOT NULL,
selltype VARCHAR(128) NOT NULL,
price INTEGER NOT NULL
);

INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Apple','f','per kg',180);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Orange','f','per kg',60);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Grapes','f','per kg',55);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Mango','f','per Dozen',500);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Banana','f','per Dozen',60);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Papaya','f','per kg',50);

INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Mint','h','per 30g',50);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Sage','h','per 100g',299);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Thyme','h','per 30g',100);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Rosemary','h','per 50g',99);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Parsley','h','per 30g',60);
INSERT INTO `product`(`name`, `category`, `selltype`, `price`) VALUES ('Basil','h','per 30g',125);

CREATE TABLE cart (
order_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
cust_id INTEGER NOT NULL REFERENCES customer(cust_id) ON DELETE CASCADE,
prod_id INTEGER NOT NULL REFERENCES product(prod_id) ON DELETE CASCADE,
quantity INTEGER NOT NULL
);

INSERT INTO `cart`(`cust_id`, `prod_id`, `quantity`) VALUES (1,4,3);
INSERT INTO `cart`(`cust_id`, `prod_id`, `quantity`) VALUES (1,7,5);
INSERT INTO `cart`(`cust_id`, `prod_id`, `quantity`) VALUES (1,10,2);
INSERT INTO `cart`(`cust_id`, `prod_id`, `quantity`) VALUES (1,2,1);