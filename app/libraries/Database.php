<?php
    /*
     * PDO database class
     * Connect to Database
     * Create prepared statements
     * Bind values
     * Return rows and results
     */
    class Database {
        private $host = DB_HOST;
        private $port = DB_PORT;
        private $user = DB_USER;
        private $pwd = DB_PWD;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct() {
            // DSN setting (Data Source Name)
            $dsn =
                "mysql:host=" . $this->host .
                ";port=" . $this->port .
                ";dbname=". $this->dbname .
                ";charset=utf8";

            // PDO options (persistent keeps the connection btw server and db server opened, even after request handling)
            // Then we want PDO to use exceptions when an error is detected
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            // Create a PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pwd, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // Prepare statement (stmt) with query
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Bind values
        public function bind($param, $value, $type=null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_string($value):
                        $type = PDO::PARAM_STR;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        // Execute the prepared statement
        public function execute() {
            return $this->stmt->execute();
        }

        // Get result set as array of objects
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Get single record as an object
        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get row count
        public function rowCount() {
            return $this->stmt->rowCount();
        }
    }