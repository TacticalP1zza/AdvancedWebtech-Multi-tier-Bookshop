<?php

require_once __DIR__ . '/DB_Connection.php';

/**
 * @class BookModel Handles book database operations.
 * @description Retrieves book data and single book records.
 */
class BookModel
{
    private $connection;

    /**
     * Initialises database connection.
     * @returns void
     */
    public function __construct()
    {
        $this->connection = DB_Connection::getConnection();
    }

    /**
     * Returns filtered books.
     * @param string $category
     * @param string $subcategory
     * @returns array
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
     * Returns book by ID.
     * @param int $bookId
     * @returns array|false
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