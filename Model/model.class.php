<?php
require_once "db_conn.php";
//bindparam vs bind_param, get_result(); bind_result
class Model
{
    private $conn;

    public function __construct()
    {
       $this -> conn = getConnection();
    }

    public function userNameExists($userName)
    {
        $sql = "SELECT id FROM Accounts WHERE userName = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function insertUser($userName, $phone, $email, $hashedPassword){

        $sql = "INSERT INTO Accounts (userName, phone, email, password) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $userName, $phone, $email, $hashedPassword);
        return $stmt->execute();

    }

   public function getUserByEmail($email){

    $sql = "SELECT * FROM Accounts WHERE email = ? email LIMIT 1 ";
    $stmt = $this ->conn->prepare($sql);
    $stmt->bind_Param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id,$dbUserName,$phone,$email,$password, $admin);

    if($stmt->fetch()){

        $user = [
            "id" => $id,
            "userName" => $dbUserName,
            "phone" => $phone,
            "email" => $email, 
            "password" => $password,
            "admin" => $admin
        ];  
        
        $stmt->close(); 
        return $user;

        }else{
            $stmt->close(); 
            return false;
        }
    
}
    public function getBooks(){

        $sql = "SELECT * FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];

        while($row = $result->fetch_assoc()){
            $books[] = $row;
        }
        return $books;
    }
}