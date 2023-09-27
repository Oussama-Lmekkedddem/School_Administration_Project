<?php
/*
class Database {
    protected $host = "localhost";
    protected $user = "admin";
    protected $password = "admin";
    protected $database = "Data";
    protected $connection;

    public function __construct() {
        try {
            $dsn = "jdbc:h2:tcp://localhost/data/{$this->database}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
*/



/*
class Database {
    private $db_file = "../Data/centreplanck.db";
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("sqlite:" . $this->db_file);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("La connexion à la base de données a échoué : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
*/


class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "Data_Project";
    private $connection;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("La connexion à la base de données a échoué : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}

/*
class Database {
    private $db_file = "../Data/centreplanck.sqlite";
    private $connection;

    public function __construct() {
        try {
            $this->connection = new PDO("sqlite:" . $this->db_file);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection to the database failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection = null;
    }
}
*/