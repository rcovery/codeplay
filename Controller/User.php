<?php
require(__DIR__ . "/../Model/DB.php");
include(__DIR__ . "/../View/message.php");

class User{
    private $db;
    
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

        $result = $this->db->select(false, "ID_user", "user", $data, ["username", "email"]);
        
        if ($result['email'] == $data['email']){
            echo "Este email já existe! Tente utilizar outro email!";
            return false;
        } else if ($result['username'] == $data["username"]){
            echo "Este nome de usuário já existe! Escolha outro!";
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

        foreach(array_values($data) as $index=>$value){
            $data[$index] = filter_var($value, FILTER_SANITIZE_STRING);
        }
        
        $result = $this->db->select(false, "ID_user", "user", $data, ["username", "password"]);
        
        if ($result['username'] != $data['username']
        || $result['password'] != $data['password']){
            (new View("Usuário ou senha incorretos!"))->warning();
            return false;
        }

        $this->getSession($result["ID_user"], $data["username"]);
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
    public function getSession($ID_user, $username){
        $_SESSION["user"] = $username;
        $_SESSION["id"] = $ID_user;
        $_SESSION["last_activity"] = time();
    }
}
?>