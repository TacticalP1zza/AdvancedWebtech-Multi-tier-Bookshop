<?php

require_once __DIR__ . '/MainController.php';

/**
 * BookController.php
 *
 * Purpose:
 * - Handles bookstore browsing
 * - Provides AJAX-based book retrieval
 * - Filters books by category and subcategory
 *
 *
 * AJAX:
 * - fetchBooks() supports asynchronous book loading without a full page reload
 * - Returns structured JSON for frontend JavaScript consumption
 *
 */

class BookController extends MainController
{
    private $bookModel;

    public function __construct($bookModel)
    {
        parent::__construct();

        $this->bookModel = $bookModel;
    }

    /**
     * showShop
     *
     * - redirects to shop page.
     * 
     * @return string View path
     */
    public function showShop()
    {
        return 'pages/shop';
    }

    /**
     * fetchBooks
     *
     * - Retrieves books filtered by category and/or subcategory.
     *
     * @return void JSON response
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