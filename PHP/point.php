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

        public function addPoint($id, $x, $y, $elevation, $timezone, $city) {
            $data = [
                "id" => $id,
                "x" => $x,
                "y" => $y,
                "elevation" => $elevation,
                "timezone" => $timezone,
                "city" => $city
            ];

            $query = $this->db->addPoint($data);
        }

        public function sendRequest() {
            $response = file_get_contents("https://api.3geonames.org/?randomland=yes");
            $xml = new SimpleXMLElement($response);

            $id = $xml->geonumber;
            $latt = $xml->nearest->latt;
            $longt = $xml->nearest->longt;
            $elevation = $xml->nearest->elevation;
            $timezone = $xml->nearest->timezone;
            $city = $xml->nearest->city;

            if (is_null($id) || is_null($latt) || is_null($longt) || is_null($elevation) || is_null($timezone) || is_null($city)) {
                    return;
            }

            $this->addPoint($id, $latt, $longt, $elevation, $timezone, $city);

        }
        
    }

    // TESTING
    $point = new Point();
    
    
    for ($i = 0; $i < 10000; $i++) {
        $point->sendRequest();
    }

    
?>

