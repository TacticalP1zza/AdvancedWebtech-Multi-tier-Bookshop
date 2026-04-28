<?php

require_once __DIR__ . '/DB_Connection.php';

/**
 * @class UserAccountsModel
 * Handles account-related database operations.
 */
class UserAccountsModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = DB_Connection::getConnection();
    }

    /**
     * @param string $email
     * @returns {bool}
     */
    public function checkEmailExists($email)
    {
        $sql = "SELECT id FROM accounts WHERE email = ? LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("emailExists prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $emailExists = $result->num_rows > 0;

        $stmt->close();

        return $emailExists;
    }

    /**
     * @param string $username
     * @param string $phone
     * @param string $email
     * @param string $hashedPassword
     * @returns {bool}
     */
    public function createUser($username, $phone, $email, $hashedPassword)
    {
        $sql = "INSERT INTO accounts (user_name, phone, email, password_hash)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("createUser prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("ssss", $username, $phone, $email, $hashedPassword);

        $success = $stmt->execute();

        if (!$success) {
            error_log("createUser execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $success;
    }

    /**
     * @param string $email
     * @returns {array|false}
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT id, user_name, phone, email, password_hash, is_admin
                FROM accounts
                WHERE email = ?
                LIMIT 1";

        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            error_log("getUserByEmail prepare failed: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user ?: false;
    }
}