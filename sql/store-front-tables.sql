CREATE TABLE IF NOT EXISTS Customers (
    customer_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(32) NOT NULL,
    last_name VARCHAR(32) NOT NULL,
    email VARCHAR(64) NOT NULL UNIQUE,
    password VARCHAR(256) NOT NULL,
    joined DATETIME NOT NULL DEFAULT NOW(),
    logged_in DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS Addresses (
    address_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    line_one VARCHAR(64) NOT NULL,
    line_two VARCHAR(64) NOT NULL,
    city VARCHAR(64) NOT NULL,
    state CHAR(2) NOT NULL,
    zipcode INTEGER UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS CustomerAddresses (
    customer_id BIGINT UNSIGNED NOT NULL,
    address_id BIGINT UNSIGNED NOT NULL,
    is_primary BOOLEAN NOT NULL DEFAULT FALSE,

    PRIMARY KEY (customer_id, address_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (address_id) REFERENCES Addresses(address_id)
);

CREATE TABLE IF NOT EXISTS Payments (
    payment_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    authorize_id VARCHAR(512) NOT NULL,
    customer_id BIGINT UNSIGNED NOT NULL,
    address_id BIGINT UNSIGNED NOT NULL,
    is_primary BOOLEAN NOT NULL DEFAULT FALSE,

    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (address_id) REFERENCES Addresses(address_id)
);

CREATE TABLE IF NOT EXISTS Manufacturers (
    manufacturer_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS ProductCategories (
    category_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Products (
    product_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    manufacturer_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(64) NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    info TEXT NOT NULL DEFAULT '',
    description TEXT NOT NULL DEFAULT '',

    FOREIGN KEY (manufacturer_id) REFERENCES Manufacturers(manufacturer_id)
);

CREATE TABLE IF NOT EXISTS ProductPictureURLs (
    picture_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    url TEXT NOT NULL,
    alt_text TEXT NOT NULL DEFAULT '',


    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

CREATE TABLE IF NOT EXISTS CategorizedProducts (
    product_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (category_id) REFERENCES ProductCategories(category_id)
);

CREATE TABLE IF NOT EXISTS Orders (
    order_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    date_time DATETIME NOT NULL DEFAULT NOW(),
    total_price DECIMAL(9, 2) NOT NULL,
    customer_id BIGINT UNSIGNED NOT NULL,
    shipping_address_id BIGINT UNSIGNED NOT NULL,

    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (shipping_address_id) REFERENCES Addresses(address_id)
);

CREATE TABLE IF NOT EXISTS OrderProducts (
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity SMALLINT UNSIGNED NOT NULL,

    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);
