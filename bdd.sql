CREATE DATABASE maison_hemera;

USE maison_hemera;

-- Table: roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    username VARCHAR(255) NOT NULL UNIQUE,
    lastname VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: address
CREATE TABLE address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    billing_address VARCHAR(255) NOT NULL,
    delivery_address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL
);

-- Table: wish_list
CREATE TABLE wish_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    product_option_id INT,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: delivery_option
CREATE TABLE delivery_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL
);

-- Table: delivery
CREATE TABLE delivery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    delivery_option_id INT,
    status VARCHAR(255) NOT NULL,
    tracking_number VARCHAR(255),
    shipped_at DATETIME,
    delivered_at DATETIME
);

-- Table: payment_methods
CREATE TABLE payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    method_name VARCHAR(255) NOT NULL,
    method_details TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: cart
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: cart_detail
CREATE TABLE cart_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    product_option_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Table: order
CREATE TABLE `order` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    payment_method_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(255) NOT NULL
);

-- Table: order_detail
CREATE TABLE order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    product_option_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Table: archived_order
CREATE TABLE archived_order (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    order_date DATETIME NOT NULL,
    archive_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: products_range
CREATE TABLE products_range (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

-- Table: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_range_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    height DECIMAL(10, 2) NOT NULL,
    weight DECIMAL(10, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: product_option
CREATE TABLE product_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    option_name VARCHAR(255) NOT NULL,
    option_value VARCHAR(255) NOT NULL
);

-- Table: colors
CREATE TABLE colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Table: social_network
CREATE TABLE social_network (
    id INT AUTO_INCREMENT PRIMARY KEY,
    network_name VARCHAR(255) NOT NULL,
    network_url VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL
);

-- Table: about_me
CREATE TABLE about_me (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    bio TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Adding Foreign Keys
ALTER TABLE users 
ADD CONSTRAINT fk_role_user FOREIGN KEY (role_id) REFERENCES roles(id);

ALTER TABLE address 
ADD CONSTRAINT fk_user_address FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE wish_list 
ADD CONSTRAINT fk_user_wishlist FOREIGN KEY (user_id) REFERENCES users(id),
ADD CONSTRAINT fk_product_wishlist FOREIGN KEY (product_id) REFERENCES products(id),
ADD CONSTRAINT fk_product_option_wishlist FOREIGN KEY (product_option_id) REFERENCES product_option(id);

ALTER TABLE delivery 
ADD CONSTRAINT fk_order_delivery FOREIGN KEY (order_id) REFERENCES `order`(id),
ADD CONSTRAINT fk_delivery_option FOREIGN KEY (delivery_option_id) REFERENCES delivery_option(id);

ALTER TABLE payment_methods 
ADD CONSTRAINT fk_user_payment FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE cart 
ADD CONSTRAINT fk_user_cart FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE cart_detail 
ADD CONSTRAINT fk_cart_cart_detail FOREIGN KEY (cart_id) REFERENCES cart(id),
ADD CONSTRAINT fk_product_cart_detail FOREIGN KEY (product_id) REFERENCES products(id),
ADD CONSTRAINT fk_product_option_cart_detail FOREIGN KEY (product_option_id) REFERENCES product_option(id);

ALTER TABLE `order` 
ADD CONSTRAINT fk_user_order FOREIGN KEY (user_id) REFERENCES users(id),
ADD CONSTRAINT fk_payment_order FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id);

ALTER TABLE order_detail 
ADD CONSTRAINT fk_order_order_detail FOREIGN KEY (order_id) REFERENCES `order`(id),
ADD CONSTRAINT fk_product_order_detail FOREIGN KEY (product_id) REFERENCES products(id),
ADD CONSTRAINT fk_product_option_order_detail FOREIGN KEY (product_option_id) REFERENCES product_option(id);

ALTER TABLE archived_order 
ADD CONSTRAINT fk_order_archived FOREIGN KEY (order_id) REFERENCES `order`(id);

ALTER TABLE products 
ADD CONSTRAINT fk_product_range FOREIGN KEY (product_range_id) REFERENCES products_range(id);

ALTER TABLE product_option 
ADD CONSTRAINT fk_product_option FOREIGN KEY (product_id) REFERENCES products(id);
