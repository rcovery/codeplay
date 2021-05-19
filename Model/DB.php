<?php
require("Connection.php");

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
        $imploded_fields = implode(",", array_keys($op["data"]));
        $data_parameters = [];
        $condition = "";
        
        // Se tiver parâmetros condicionais
        if (isset($op["conditional"])){
            foreach ($op["conditional"] as $i=>$value){
                $data_parameters[":$value"] = $op["data"][$value];
                $condition .= "$value = :$value";

                // if length array - 1 < index
                if ($i < sizeof($op["conditional"]) - 1){
                    $condition .= " OR ";
                }
            }

            // Gera uma query SELECT com a condição
            $this->query = "SELECT {$op["id"]}, {$imploded_fields} FROM {$op["entity"]} WHERE {$condition}";

            $prepared = $this->conn->prepare($this->query);
            $prepared->execute($data_parameters);
        } else {
            // Gera uma query sem condição
            $this->query = "SELECT {$op["id"]}, {$imploded_fields} FROM {$op["entity"]}";
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
	 * @return $result
     */
    public function insert($entity, $data){
        $imploded_fields = implode(",", array_keys($data));
        $data_parameters = [];

        foreach ($data as $key=>$value){
            $data_parameters[":$key"] = $value;
        }

        $values = implode(",", array_keys($data_parameters));

        $this->query = "INSERT INTO {$entity} ($imploded_fields) VALUES ({$values})";
        $prepared = $this->conn->prepare($this->query);
        $prepared->execute($data_parameters);
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
     * ---> [IMCOMPLETO]
     * @param string $entity
     * @param string $id
	 * @return $result
     */
    public function update($entity, $id){
        /* $this->query = "DELETE * FROM {$entity} WHERE id = {$id}";
        
        $prepared = $this->conn->prepare($this->query);
        $prepared->execute();
        
        $prepared->fetch();

        return true; */
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