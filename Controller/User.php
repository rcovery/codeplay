<?php
require_once(dirname(__FILE__) . "/../Model/DB.php");
require_once(dirname(__FILE__) . "/../pages/message.php");

class User{
    private $db;
    private $select_options;
    
    public function __construct(){
        $this->db = new Database;
    }
    
    /**
    * Função para criar um usuário no banco de dados
    *
    * @param array $data
    * @return boolean
    * @author Ryan
    */
    public function createUser($data){
        $password = hash("sha512", $data[":password"]);
        unset($data[":password"]);

        if(preg_match('/[\'\/~`\!#\$%\^&\*\(\)@\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $data[":username"])){
            (new View("Não é permitido símbolos especiais!"))->warning();
            return false;
        }

        foreach(array_values($data) as $index=>$value){
            if (gettype($index) != "integer"){
                $data[$index] = $value;
            }
        }

        $this->select_options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "username = :username OR email = :email"
        ];

        $result = $this->db->select($this->select_options);
        
        if (isset($result['email']) && $result['email'] == $data[':email']){
            (new View("Este email já existe! Tente utilizar outro email!"))->warning();
            return false;
        } else if (isset($result['username']) && $result['username'] == $data[":username"]){
            (new View("Este nome de usuário já existe! Escolha outro!"))->warning();
            return false;
        }

        $data[":password"] = $password;
        $fields = "email, username, password";
        
        $this->db->insert("user", $data, $fields);
        
        return true; 
    }
    
    /**
    * Função para fazer login
    *
    * @param array $data
    * @return boolean
    * @author Ryan
    */
    public function login($data){
        $data[":password"] = hash("sha512", $data[":password"]);
        $keep_logged = $data["keep_logged"];
        unset($data["keep_logged"]);

        if(preg_match('/[\'\/~`\!#\$%\^&\*\(\)@\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $data[":username"])){
            (new View("Não é permitido caracteres especiais!"))->warning();
            return false;
        }
        
        $this->select_options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "username = :username OR password = :password"
        ];

        $result = $this->db->select($this->select_options);

        if (!isset($result['username']) || $result['username'] != $data[':username']
        || !isset($result['password']) || $result['password'] != $data[':password']){
            (new View("Usuário ou senha incorretos!"))->warning();
            return false;
        }

        $this->getSession($result["ID_user"], $data[":username"], $keep_logged);
        return true; 
    }
    
    /**
    * Função para conseguir uma sessão
    *
    * @param int $ID_user
    * @param string $username
    * @param boolean $keep_logged
    * @return boolean
    * @author Ryan
    */
    public function getSession($ID_user, $username, $keep_logged){
        $_SESSION["user"] = $username;
        $_SESSION["id"] = $ID_user;
        $_SESSION["last_activity"] = time();
        $_SESSION["keep_logged"] = $keep_logged;
    }

    /**
    * Função para conseguir informações do usuário
    *
    * @param int $ID_user
    * @return array
    * @author Ryan
    */
    public function getUser($ID_user){
        $data[":ID_user"] = $ID_user;

        $this->select_options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "ID_user = :ID_user"
        ];

        $result = $this->db->select($this->select_options);

        return $result;
    }
}
?>