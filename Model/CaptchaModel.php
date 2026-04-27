<?php

require_once __DIR__ . '/DB_Connection.php';

/**
 * CaptchaModel.php
 *
 * Handles getting CAPTCHA images and validateing user Captcha input.
 */

class CaptchaModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB_Connection::getConnection();
    }

    /**
     * Get a random CAPTCHA image.
     */
    public function getRandomCaptcha()
    {
        $sql = "SELECT id, image_name
                FROM captcha_images
                ORDER BY RAND()
                LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getRandomCaptcha prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $captcha = $result->fetch_assoc();

        $stmt->close();

        return $captcha ?: false;
    }

    /**
     * Check whether the entered CAPTCHA matches the database Answer.
     */
    public function captchaMatches($captchaId, $captchaInput)
    {
        $sql = "SELECT id
                FROM captcha_images
                WHERE id = ? AND captcha_text = ?
                LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("captchaMatches prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("is", $captchaId, $captchaInput);
        $stmt->execute();

        $result = $stmt->get_result();
        $captchaMatches = $result->num_rows > 0;

        $stmt->close();

        return $captchaMatches;
    }
}