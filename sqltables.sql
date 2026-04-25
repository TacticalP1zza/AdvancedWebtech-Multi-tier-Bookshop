CREATE TABLE Accounts (

    id INT AUTO_INCREMENT PRIMARY KEY,

    userName VARCHAR(50) NOT NULL,

    phone VARCHAR(10) NOT NULL,

    email VARCHAR(255) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    admin BOOLEAN DEFAULT FALSE


);

CREATE TABLE products (

id INT AUTO_INCREMENT PRIMARY KEY,

isbn VARCHAR(20) UNIQUE,

title VARCHAR(255) NOT NULL,

author VARCHAR(255),
    
genre VARCHAR(255),

category VARCHAR(100),

subcategory VARCHAR(100),

price DECIMAL(6,2),

image VARCHAR(255),

description TEXT,

stock INT DEFAULT 10


);

CREATE TABLE orders (

id INT AUTO_INCREMENT PRIMARY KEY,

account_id INT NOT NULL,

product_id INT NOT NULL,

quantity INT DEFAULT 1,

price DECIMAL(6,2) NOT NULL,

order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (account_id) REFERENCES Accounts(id),

FOREIGN KEY (product_id) REFERENCES products(id)

);

CREATE TABLE CaptchaImages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imageName VARCHAR(100) NOT NULL,
    captchaText VARCHAR(20) NOT NULL
);
wasnt a v on image 4 change to q
INSERT INTO CaptchaImages (imageName, captchaText) VALUES
('image1.jpg', 'Aeika'),
('image2.jpg', 'ecb4f'),
('image3.jpg', '7PLBJ8'),
('image4.jpg', '24vu3');

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    price DECIMAL(6,2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (account_id) REFERENCES Accounts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);