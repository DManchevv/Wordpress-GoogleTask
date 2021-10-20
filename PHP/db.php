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
            $sql = "INSERT INTO google_maps_points (pointId, x, y) VALUES (:pointId, :x, :y)";
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

        public function findPointById($pointId) {
            try {
                $this->pointWithId->execute(["pointId" => $pointId]);
                return ["success" => true, "point" => $this->pointWithId->fetchAll(PDO::FETCH_ASSOC)];
            } catch (PDOExcepteion $e) {
                return ["success" => false];
            }
        }

        public function getAllPoints() {
            $result = $this->connection->query('SELECT x FROM google_maps_points');
            
            $info = $result->fetchAll();
            
            $jsonTable = json_encode($info);
        }

        function __destruct() 
        {
            $this->connection = null;
        }
    }

?>
