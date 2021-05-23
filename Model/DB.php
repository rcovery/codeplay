<?php
require_once("Connection.php");

class Database{
    private $query;

    public function __construct(){
        $this->conn = Connection::getInstance(dirname(__FILE__) . '/../database.ini');
    }

    /**
     * Função para fazer select no banco de dados
     * Você pode escolher pegar todos ou o primeiro registro
     *
     * @param array $op
	 * @return $result
     */
    public function select($op){
        $this->query = "SELECT {$op['fields']} FROM {$op["entity"]}";
        // Se tiver parâmetros condicionais

        if (isset($op["conditional"])){
            // Gera uma query SELECT com a condição
            $this->query .= " WHERE {$op['conditional']}";

            $prepared = $this->conn->prepare($this->query);
            $prepared->execute($op['data']);
        } else {
            // Executa uma query sem condição
            $prepared = $this->conn->prepare($this->query);
            $prepared->execute();
        }

        // Se o parâmetro de selecionar todos os dados for true, ele executa e salva na variável $result
        $result = $op["all"] ? $prepared->fetchAll() : ($prepared->fetchAll()[0] ?? null);

        return $result;
    }

    /**
     * Função para inserir informações no banco de dados, não tem muito segredo
     *
     * @param string $entity
     * @param array $data
     * @param string $fields
	 * @return $result
     */
    public function insert($entity, $data, $fields){
        $imploded_fields = implode(",", array_keys($data));

        $values = implode(",", array_keys($data));

        $this->query = "INSERT INTO {$entity} ($fields) VALUES ({$values})";

        $prepared = $this->conn->prepare($this->query);
        $prepared->execute($data);
    }

    /**
     * Função para deletar informações do banco de dados
     *
     * @param string $entity
     * @param string $id
	 * @return $result
     */
    public function delete($entity, $id){
        $this->query = "DELETE * FROM {$entity} WHERE id = {$id}";
        
        $prepared = $this->conn->prepare($this->query);
        $prepared->execute();

        return true;
    }

    /**
     * Função para atualizar informações do banco de dados
     *
     *
     * @param string $entity
     * @param string $id
	 * @return $result
     */
    public function update($op){
        $this->query = "UPDATE {$op['entity']} SET {$op['set']}";

        if (isset($op['conditional'])) {
            $this->query .= " WHERE {$op['conditional']}";
        }
        
        $prepared = $this->conn->prepare($this->query);
        $prepared->execute($op['data']);
        
        $prepared->fetch();

        return true;
    }

    /**
     * Função para fazer buscar por nome no banco de dados
     *
     * @param array $op
     * @return $result
     */
    public function findByName($op){
        $condition = $op['conditional'];
        $data_parameters = $op['data'];

        // Gera uma query SELECT com a condição
        $this->query = "SELECT * FROM {$op["entity"]} WHERE {$condition}";

        $prepared = $this->conn->prepare($this->query);
        $prepared->execute($data_parameters);

        // Se o parâmetro de selecionar todos os dados for true, ele executa e salva na variável $result
        $result = $prepared->fetchAll();

        return $result;
    }
}
?>