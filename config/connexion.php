<?php 

class DbConnection{
    private $host = "localhost";
    private $db_name = "GameVault";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username, $this->password
            );
        }catch(PDOException $e){
            echo "erreur during the connection: ". $e->getMessage();
        }
        return $this->conn;

    }
}
?>

