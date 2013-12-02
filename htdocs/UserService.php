<?php

	class UserService {
		private $connection;

		public function __construct() {
			$connection = new Connection();
		}

		public function create($table, $data) {
			pg_insert($this->connection, $table, $data) or die ("Erro ao inserir dados.");
		}
	}
?>