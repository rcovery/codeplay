<?php
class Connection{
	private static $conn;
	
	private function __construct(){}
	private function __clone(){}
	public function __wakeup(){
		self::getInstance("../database.ini");
	}

	/**
     * Função para carregar o arquivo de configuração do banco de dados
	 * A função retorna um array com as informações
     *
     * @param string $file
	 * @return $data
     */
	private static function load_config(string $file){
		if (file_exists($file)) $data = parse_ini_file($file);
		else {
			echo "Config file not found!";
			throw new Exception("File not found!");
		}

		return $data;
	}

	/**
     * Função que faz a conexão ao banco de dados utilizando PDO
	 * Ela captura os dados retornados da função load_config
     *
     * @param string $config
	 * @return PDO
     */
	private static function makeConnection(array $config){
		$host = isset($config['server']) ? $config['server'] : null;
		$port = isset($config['port']) ? $config['port'] : null;
		$user = isset($config['user']) ? $config['user'] : null;
		$pass = isset($config['pass']) ? $config['pass'] : null;
		$dbms = isset($config['dbms']) ? $config['dbms'] : null;
		$dbname = isset($config['dbname']) ? $config['dbname'] : null;

		if (!is_null($dbms)){
			return new PDO($dbms.":host=".$host.";dbname=".$dbname, $user, $pass);
			/*switch(strtoupper($host)){
				case 'MYSQL':
					$conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $pass)
					break;			
			}*/
		}else throw new Exception("DBMS is NULL!");
	}

	/**
     * Função para criar uma instância.
	 * Se já existir uma instância, ele utiliza a que já foi criada.
	 * Recebe como parâmetro o nome do arquivo de configuração do database
     *
     * @param string $configfile
	 * @return $conn
     */
	public static function getInstance(string $configfile){
		if(self::$conn == null){
			self::$conn = self::makeConnection(self::load_config($configfile));
		}
		
		return self::$conn;
	}
}
?>
