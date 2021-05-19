<?php
require(dirname(__FILE__) . "/../Model/DB.php");
include(dirname(__FILE__) . "/../pages/message.php");

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
        $data["password"] = hash("sha512", $data["password"]);

        foreach(array_values($data) as $index=>$value){
            if (gettype($index) != "integer"){
                $data[$index] = filter_var($value, FILTER_SANITIZE_STRING);
            }
        }

        $this->select_options = [
            "all" => false,
            "id" => "ID_user",
            "entity" => "user",
            "data" => $data,
            "conditional" => ["username", "email"]
        ];

        $result = $this->db->select($this->select_options);
        
        if ($result['email'] == $data['email']){
            (new View("Este email já existe! Tente utilizar outro email!"))->warning();
            return false;
        } else if ($result['username'] == $data["username"]){
            (new View("Este nome de usuário já existe! Escolha outro!"))->warning();
            return false;
        }
        
        $this->db->insert("user", $data);
        
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
        $data["password"] = hash("sha512", $data["password"]);
        $keep_logged = $data["keep_logged"];
        unset($data["keep_logged"]);

        foreach(array_values($data) as $index=>$value){
            if (gettype($index) != "integer"){
                $data[$index] = filter_var($value, FILTER_SANITIZE_STRING);
            }
        }
        
        $this->select_options = [
            "all" => false,
            "id" => "ID_user",
            "entity" => "user",
            "data" => $data,
            "conditional" => ["username", "password"]
        ];

        $result = $this->db->select($this->select_options);

        echo $result["username"];
        
        if ($result['username'] != $data['username']
        || $result['password'] != $data['password']){
            (new View("Usuário ou senha incorretos!"))->warning();
            return false;
        }

        $this->getSession($result["ID_user"], $data["username"], $keep_logged);
        return true; 
    }
    
    /**
    * Função para conseguir uma sessão
    *
    * @param int $ID_user
    * @param string $username
    * @return boolean
    * @author Ryan
    */
    public function getSession($ID_user, $username, $keep_logged){
        $_SESSION["user"] = $username;
        $_SESSION["id"] = $ID_user;
        $_SESSION["last_activity"] = time();
        $_SESSION["keep_logged"] = $keep_logged;
    }
}
?>