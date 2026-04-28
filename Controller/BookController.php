<?php

require_once __DIR__ . '/MainController.php';

/**
 * @class BookController Handles bookstore browsing.
 * @description Controls shop view and book retrieval.
 */
class BookController extends MainController
{
    private $bookModel;

    /**
     * @param BookModel $bookModel
     */
    public function __construct($bookModel)
    {
        parent::__construct();
        $this->bookModel = $bookModel;
    }

    /**
     * Returns shop view.
     * @returns string
     */
    public function showShop()
    {
        return 'pages/shop';
    }

    /**
     * Outputs books as JSON.
     * @returns void
     */
    public function fetchBooks()
    {
        $category = $this->getInput($_GET, 'category');
        $subcategory = $this->getInput($_GET, 'subcategory');

        $books = $this->bookModel->getBooks($category, $subcategory);

        $this->jsonResponse([
            'success' => true,
            'data' => $books
        ]);
    }
}