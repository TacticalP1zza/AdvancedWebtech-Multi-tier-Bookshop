<?php

require_once __DIR__ . '/DB_Connection.php';

/**
 * BookModel.php
 *
 * Handles book/product database operations.
 */

class BookModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB_Connection::getConnection();
    }

    /**
     * Retrieve books, optionally filtered by category and subcategory.
     */
    public function getBooks($category = '', $subcategory = '')
    {
        $sql = "SELECT 
                    id,
                    isbn,
                    title,
                    author,
                    genre,
                    category,
                    subcategory,
                    price,
                    image_url,
                    description,
                    stock
                FROM products
                WHERE 1 = 1";

        $params = [];
        $types = "";

        if ($category !== '') {
            $sql .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }

        if ($subcategory !== '') {
            $sql .= " AND subcategory = ?";
            $params[] = $subcategory;
            $types .= "s";
        }

        $sql .= " ORDER BY title ASC LIMIT 50";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getBooks prepare failed: " . $this->connection->error);
            return [];
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $books = [];

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        $stmt->close();

        return $books;
    }

    /**
     * Retrieve one book by ID.
     */
    public function getBookById($bookId)
    {
        $sql = "SELECT 
                    id,
                    isbn,
                    title,
                    author,
                    genre,
                    category,
                    subcategory,
                    price,
                    image_url,
                    description,
                    stock
                FROM products
                WHERE id = ?
                LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getBookById prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("i", $bookId);
        $stmt->execute();

        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        $stmt->close();

        return $book ?: false;
    }
}