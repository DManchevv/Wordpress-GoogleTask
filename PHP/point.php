<?php

    require_once 'db.php';
    header('Content-Type: application/json');

    class Point {
        private $pointId;
        private $x;
        private $y;

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

        public function getPointId() {
            return $this->pointId;
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

        public function getAllPoints() {
            $this->db->getAllPoints();
        }
    }

    // TESTING
    //$point = new Point();
    //$point->addPoint("6", 13.196, 21.113);
    //$point->getAllPoints();
?>
