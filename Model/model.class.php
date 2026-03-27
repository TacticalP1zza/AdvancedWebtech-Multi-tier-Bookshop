<?php
require_once "db_conn.php";
class Model
{
    private $conn;

    public function __construct()
    {
       $this -> conn = getConnection();
    }

    public function userNameExists($userName)
    {
        $sql = "SELECT id FROM customersAccounts WHERE userName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt ->get_result();

        return $result->num_rows > 0;
    }

    public function insertUser($userName, $phone, $email, $hashedPassword){

        $sql = "INSERT INTO customersAccounts (userName, phone, email, password) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $userName, $phone, $email, $hashedPassword);
        return $stmt->execute();

    }

    public function getUserByUserName($userName)

    $sql = "SELECT * FROM customersAccounts WHERE userName = :userName LIMIT 1 ";
    $stmt = $this ->db->prepare($sql);
    $stmt-> bindParam('')
    


}