<?php
//A very ugly Connection class. But it's only a prototype :)

    class Connection {
        //private $conUrl = "host=ec2-75-101-167-151.compute-1.amazonaws.com port=5432 dbname=d3ggitkqdavhrf user=upnhxxktbsskuv password=PZCwspR9BO4bmkyuOYZ0mDaPLN sslmode=require options='--client_encoding=UTF8'";
        private $conUrl = 'host=ec2-54-204-35-114.compute-1.amazonaws.com user=mrayelanmugzof password=EcuoAao-pxDjVZyC-6_y_bL8hW dbname=dfsf9l8k3qkqpu';

        public function __construct() {}

        public function create($table, $data) {
            $connection = $this->getConnection();
            pg_insert($connection, $table, $data) or die ("Erro ao inserir dados.");
            $this->closeConnection($connection);
        }

        public function delete($table, $data) {
            $connection = $this->getConnection();
            pg_delete($connection, $table, $data) or die ("Erro ao inserir dados.");
            $this->closeConnection($connection);
        }

        public function setPlan($parkingId, $planId) {
            $data = array('plan' => $planId);
            $where = array('id' => $parkingId);
            $connection = $this->getConnection();
            pg_update($connection, "parking", $data, $where) or die ("Erro ao inserir dados.");
            $this->closeConnection($connection);
        }

        public function registerOut($date ,$registerId) {
            $data = array('register_end' => $date, 'active' => 'false');
            $where = array('id' => $registerId);
            $connection = $this->getConnection();
            pg_update($connection, "register", $data, $where) or die ("Erro ao inserir dados.");
            $this->closeConnection($connection);
        }

        public function setConfig($parkingId, $field, $value) {
            $data = array($field => $value);
            $where = array('id' => $parkingId);
            $connection = $this->getConnection();
            pg_update($connection, "parking", $data, $where) or die ("Erro ao inserir dados.");
            $this->closeConnection($connection);
        }

        public function listRegisters($parkingId) {
            $connection = $this->getConnection();
            $query = "SELECT * FROM register WHERE parking = " . $parkingId . " AND active = true";
            $result = @pg_query($connection, $query);
            $row = 0;
            $resultArr = array();
            while ($resultArr[$row] = @pg_fetch_array($result, $row, PGSQL_ASSOC)) {
                 $row += 1;
            }
            $this->closeConnection($connection);
            return $resultArr;
        }

        public function listRegistersOut($parkingId) {
            $connection = $this->getConnection();
            $query = "SELECT * FROM register WHERE parking = " . $parkingId . " AND active = false";
            $result = @pg_query($connection, $query);
            $row = 0;
            $resultArr = array();
            while ($resultArr[$row] = @pg_fetch_array($result, $row, PGSQL_ASSOC)) {
                 $row += 1;
            }
            $this->closeConnection($connection);
            return $resultArr;
        }

        public function listParkingsByName($name) {
            $connection = $this->getConnection();
            $query = "SELECT id, name FROM parking WHERE llower(name) like llower('%" . $name . "%')";
            $query = str_replace("llower", "lower", $query);
            $result = @pg_query($connection, $query);
            $row = 0;
            $resultArr = array();
            while ($resultArr[$row] = @pg_fetch_array($result, $row, PGSQL_ASSOC)) {
                 $row += 1;
            }
            $this->closeConnection($connection);
            return $resultArr;
        }

        public function listFakeParks() {
            $connection = $this->getConnection();
            $query = "SELECT id, name FROM parking WHERE id in (19, 20, 21, 22)";
            $result = @pg_query($connection, $query);
            $row = 0;
            $resultArr = array();
            while ($resultArr[$row] = @pg_fetch_array($result, $row, PGSQL_ASSOC)) {
                 $row += 1;
            }
            $this->closeConnection($connection);
            return $resultArr;
        }

        public function listPeriods($parkingId) {
            $connection = $this->getConnection();
            $query = "SELECT id, start_hour, end_hour, start_day, end_day FROM period WHERE parking = " . $parkingId;
            $result = @pg_query($connection, $query);
            $row = 0;
            $resultArr = array();
            while ($resultArr[$row] = @pg_fetch_array($result, $row, PGSQL_ASSOC)) {
                 $row += 1;
            }
            $this->closeConnection($connection);
            return $resultArr;
        }

        public function findParkingById($id) {
            $connection = $this->getConnection();
            $query = "SELECT name, address, neighborhood, city, state, telephone, email, week_start_hour, week_end_hour, weekend_start_hour,";
            $query .= " weekend_end_hour, responsible, first_hour, additional_hour, reservation_tax, monthly_tax, park_quantity, reservation_quantity,";
            $query .= " plan FROM parking WHERE id = " . $id;
            $result = @pg_query($connection, $query);
            $arr = @pg_fetch_array($result, 0, PGSQL_ASSOC);
            $this->closeConnection($connection);
            return $arr;
        }

        public function getLoginId($username, $password) {
            $connection = $this->getConnection();
            $query = "SELECT usuario_id FROM usuario WHERE usuario_login = '".$username."' AND usuario_senha = '".$password."'";
            $result = @pg_query($connection, $query);
            $arr = @pg_fetch_array($result, 0, PGSQL_NUM);
            $this->closeConnection($connection);
            return $arr[0];
        }

        public function getParkingId($loginId) {
            $connection = $this->getConnection();
            $query = "SELECT id FROM parking WHERE login = " . $loginId;
            $result = @pg_query($connection, $query);
            $arr = @pg_fetch_array($result, 0, PGSQL_NUM);
            $this->closeConnection($connection);
            return $arr[0];
        }

        public function getPlanId($parkingId) {
            $connection = $this->getConnection();
            $query = "SELECT plan FROM parking WHERE id = " . $parkingId;
            $result = @pg_query($connection, $query);
            $arr = @pg_fetch_array($result, 0, PGSQL_NUM);
            $this->closeConnection($connection);
            return $arr[0];
        }

        public function findPlanById($id) {
            $connection = $this->getConnection();
            $query = "SELECT id, name, value FROM plan WHERE id = " . $id;
            $result = @pg_query($connection, $query);
            $arr = @pg_fetch_array($result, 0, PGSQL_ASSOC);
            $this->closeConnection($connection);
            return $arr;
        }

        private function getConnection() {
            return @pg_connect($this->conUrl);
        }

        private function closeConnection($connection) {
            @pg_close($connection);
        }

        private function isConnected() {
            return $this->connection ? true : false;
        }
    }
?>