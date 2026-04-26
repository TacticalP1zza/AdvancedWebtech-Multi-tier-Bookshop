<?php

/**
 * View.php
 *
 * Purpose:
 * - Handles rendering of pages
 * - Receives prepared data from controller
 *
 */

class View
{
    /**
     *
     * @param string $page Path to view file
     * @param array $data Optional data passed from controller
     * @return string Rendered HTML
     */
    public function output($response)
    {
        ob_start();
    
        if (is_array($response)) {
            $page = $response['page'];
            $data = $response['data'] ?? [];
    
            extract($data);
        } else {
            $page = $response;
        }
    
        require __DIR__ . "/layouts/header.php";
        require __DIR__ . "/" . $page . ".php";
        require __DIR__ . "/layouts/footer.php";
    
        return ob_get_clean();
    }
}