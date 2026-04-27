CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    genre VARCHAR(255),
    category VARCHAR(100),
    subcategory VARCHAR(100),
    price DECIMAL(6,2) NOT NULL,
    image_url VARCHAR(255),
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

    CONSTRAINT fk_orders_account
        FOREIGN KEY (account_id) REFERENCES accounts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_orders_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE captcha_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(100) NOT NULL,
    captcha_text VARCHAR(20) NOT NULL
);

INSERT INTO captcha_images (image_name, captcha_text) VALUES
('image1.jpg', 'Aeika'),
('image2.jpg', 'ecb4f'),
('image3.jpg', '7PLBJ8'),
('image4.jpg', '24qu3');

INSERT INTO products (isbn, title, author, genre, category, subcategory, price, image_url, description, stock) VALUES

('9780747532743', 'Harry Potter and the Young Wizard', 'J.K. Rowling', 'Fantasy', 'Kids', 'Young', 9.99, 'img/hp.jpg', 'A young wizard discovers magic.', 15),
('9780241523561', 'My First Animals', 'Laura Baker', 'Educational', 'Kids', 'Infants', 5.50, 'img/animals.jpg', 'Picture book for toddlers.', 20),
('9781405288192', 'Junior Science Experiments', 'Tom Field', 'Educational', 'Kids', 'Junior', 7.99, 'img/science.jpg', 'Fun science projects for children.', 12),
('9780261103573', 'The Fellowship Adventure', 'J.R.R. Tolkien', 'Fantasy', 'Adults', 'Classic Novels', 14.99, 'img/fellowship.jpg', 'Epic fantasy journey.', 8),
('9780553103540', 'Game of Kingdoms', 'George R.R. Martin', 'Fantasy', 'Adults', 'Fiction', 16.75, 'img/gok.jpg', 'Political fantasy drama.', 6),
('9780062073488', 'The Detective Files', 'Arthur Conan Doyle', 'Crime', 'Adults', 'Crime and Thriller', 11.20, 'img/detective.jpg', 'Classic detective stories.', 10),
('9781302916141', 'Amazing Hero Comics', 'Stan Lee', 'Superhero', 'Adults', 'Comic', 8.99, 'img/comic.jpg', 'Superhero adventures.', 25),
('9781784877986', 'Mystery of the Old House', 'Agatha Christie', 'Mystery', 'Adults', 'Crime and Thriller', 10.50, 'img/mystery.jpg', 'A classic mystery novel.', 9),
('9780008305008', 'Modern Love Stories', 'Emma Reed', 'Romance', 'Adults', 'Fiction', 12.30, 'img/love.jpg', 'Collection of romantic stories.', 7),
('9780755500400', 'Young Space Explorers', 'David Walliams', 'Adventure', 'Kids', 'Young', 8.60, 'img/space.jpg', 'Kids explore space adventures.', 18),

('9780000000011', 'Bedtime Stories for Little Ones', 'Sarah Green', 'Children', 'Kids', 'Infants', 4.99, 'img/book.jpg', 'Short bedtime stories for toddlers.', 20),
('9780000000012', 'Alphabet Adventures', 'Lily Brown', 'Educational', 'Kids', 'Infants', 5.25, 'img/book.jpg', 'Learning the alphabet through fun stories.', 18),
('9780000000013', 'Junior Maths Made Easy', 'Chris White', 'Educational', 'Kids', 'Junior', 6.75, 'img/book.jpg', 'Basic maths concepts for young learners.', 14),
('9780000000014', 'The Young Inventors Club', 'Tom Hardy', 'Adventure', 'Kids', 'Junior', 7.40, 'img/book.jpg', 'Kids build creative inventions together.', 11),
('9780000000015', 'Teen Mystery Squad', 'Rachel Adams', 'Mystery', 'Kids', 'Young', 8.20, 'img/book.jpg', 'A group of teens solve local mysteries.', 13),
('9780000000016', 'Dragons of the North', 'Evan Stone', 'Fantasy', 'Kids', 'Young', 9.10, 'img/book.jpg', 'A fantasy tale of dragons and heroes.', 16),
('9780000000017', 'Victorian Tales Collection', 'Charles Dickens', 'Classic', 'Adults', 'Classic Novels', 13.50, 'img/book.jpg', 'A collection of Victorian era stories.', 9),
('9780000000018', 'Modern Business Thinking', 'Alan Cooper', 'Business', 'Adults', 'Fiction', 15.80, 'img/book.jpg', 'Fictional insights into modern business.', 7),
('9780000000019', 'The Silent Witness', 'Nina Blake', 'Crime', 'Adults', 'Crime and Thriller', 11.75, 'img/book.jpg', 'A suspenseful courtroom drama.', 10),
('9780000000020', 'Galaxy Warriors Comic Vol.1', 'Mark Steel', 'Sci-Fi', 'Adults', 'Comic', 9.45, 'img/book.jpg', 'A futuristic comic adventure series.', 22);