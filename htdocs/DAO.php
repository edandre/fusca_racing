class Connection {
	private $connection;

	private $host = "localhost";
    private $username = "postgres";
    private $password = "300610";
    private $database = "fuscao";

	public function __construct() {
        $this->openConnection();
    }

    private function openConnection() {
            $this->connection = pg_connect("host=$this->host user=$this->username password=$this->password dbname=$this->database") or die ("Erro ao tentar conectar local.");
    }

    private function closeConnection() {
            @pg_close($this->connection);
    }

    private function isConnected() {
            return $this->connection ? true : false;
    }

    public static function create($table, $data) {
            if (!isConnected()) {
                    $this->openConnection();
            }
            
            pg_insert($connectionManager->getConnection, $table, $data) or die ("Erro ao inserir dados.");
            $this->closeConnection();
    }

}

class UserService {
	private $connection;

	public function __construct() {
		$connection = new Connection();
	}

	public function create($table, $data) {
		pg_insert($this->connection, $table, $data) or die ("Erro ao inserir dados.");
	}
}