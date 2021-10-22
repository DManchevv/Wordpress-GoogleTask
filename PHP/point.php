<?php

    require_once 'db.php';
    header('Content-Type: application/json');

    class Point {
        private $x;
        private $y;
        private $pointId;
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function setX($x) {
            $this->x = $x;
        }

        public function setY($y) {
            $this->y = $y;
        }

        public function getX() {
            return $this->x;
        }

        public function getY() {
            return $this->y;
        }

        public function addPoint($pointId, $x, $y) {
            $data = [
                "pointId" => $pointId,
                "x" => $x,
                "y" => $y,
            ];

            $query = $this->db->addPoint($data);
        }
/*
        public function findIfPointWithIdExists($pointId) {
            $foundPoint = $this->db->findPointById($pointId);
            if ($foundPoint["success"]) {
                echo "Point with this id is found!\n";
                return true;
            }
            else {
                echo "Point with this id not found!\n";
                return false;
            }
        }
*/
        public function getAllPoints() {
            $this->db->getAllPoints();
        }

        public function sendRequest() {
            $response = file_get_contents("https://random-data-api.com/api/number/random_number?size=100&is_xml=true");
            
            $xml = new SimpleXMLElement($response);
            $counter = 1;
            $lat = 0;

            foreach($xml->object as $object) {
                if ($counter % 2 === 1) {
                    $lat = $object->id;
                }
                else {
                    $this->addPoint("1", $this->adjustNumber($lat, 2), $this->adjustNumber($object->id, 3));
                }

                $counter++;
            }

        }

        public function adjustNumber($x, $precision) {
            $dividor = intval(strlen(strval($x))) - $precision;
            
            return $x / pow(10, $dividor);
        }
        
    }

    // TESTING
    $point = new Point();
    
    for ($i = 1; $i <= 500; $i++) {
        $point->sendRequest();
    }

    
?>
