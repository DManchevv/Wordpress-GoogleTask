<?php
    class Database {
        private $connection;
        private $insertPoint;
        private $pointWithId;
        private $getPoints;

        public function __construct() 
        {
            $config = parse_ini_file('config.ini', true);
            $type = $config['db']['type'];
            $host = $config['db']['host'];
            $name = $config['db']['name'];
            $user = $config['db']['user'];
            $password = $config['db']['password'];

            $this->init($type, $host, $name, $user, $password);
        }

        private function init($type, $host, $name, $user, $password) 
        {
            try {
                $this->connection = new PDO("$type:host=$host;dbname=$name", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $this->prepareStatements();

                echo "Connection successful\n";
                
            } catch (PDOException $e) {
                echo "Connection failed" . $e->getMessage();
            }
        }

        public function prepareStatements() {
            $sql = "INSERT INTO google_maps_points (id, x, y, elevation, timezone, city) VALUES (:id, :x, :y, :elevation, :timezone, :city)";
            $this->insertPoint = $this->connection->prepare($sql);

            $sql = "SELECT * FROM google_maps_points WHERE pointId = :pointId";
            $this->pointWithId = $this->connection->prepare($sql);

            $sql = "SELECT x, y FROM google_maps_points";
            $this->getPoints = $this->connection->prepare($sql);
        }

        public function addPoint($data) {
            try {
                $this->insertPoint->execute($data);
                return ["success" => true];
            } catch(PDOException $e) {
                echo "Connection failed" . $e->getMessage(); 
                return ["success" => false];
            }
        }

        function __destruct() 
        {
            $this->connection = null;
        }
    }

?>
