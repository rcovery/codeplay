<?php
require_once(dirname(__FILE__) . "/../Model/DB.php");
require_once(dirname(__FILE__) . "/../pages/message.php");

class User{
    private $db;
    private $options;
    
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

        foreach(array_values($data) as $index=>$value){
            if (gettype($index) != "integer"){
                $data[$index] = $value;
            }
        }

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "username = :username OR email = :email"
        ];

        $result = $this->db->select($this->options);
        
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

        (new View("Conta criada com sucesso!"))->success();
        
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

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "username = :username AND password = :password"
        ];

        $result = $this->db->select($this->options);

        if (!isset($result['username']) || !isset($result['password'])) {
            (new View("Usuário ou senha incorretos!"))->warning();
            return false;
        }

        $this->getSession($result["ID_user"], $result["username"], $keep_logged, $result['is_admin']);
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
    public function getSession($ID_user, $username, $keep_logged, $admin = null){
        $_SESSION["user"] = $username;
        $_SESSION["id"] = $ID_user;
        $_SESSION["last_activity"] = time();
        $_SESSION["keep_logged"] = $keep_logged;
        if ($admin == 1) {
            $_SESSION['is_admin'] = true;
        }
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

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "user",
            "data" => $data,
            "conditional" => "ID_user = :ID_user"
        ];

        $result = $this->db->select($this->options);

        return $result;
    }

    /**
    * Função para atualizar perfil no banco de dados
    *
    * @param array $data
    * @param array $files
    * @return boolean
    * @author Ryan
    */
    public function updateProfile($data, $files = null){
        $data[':bio'] = str_replace("<", "&#60;", $data[':bio']);
        $data[':username'] = str_replace("<", "&#60;", $data[':username']);

        if (!file_exists("../assets/uploads")) mkdir("../assets/uploads", 0777);
        if (!file_exists("../assets/uploads/" . $data[':ID_user'])) mkdir("../assets/uploads/" . $data[':ID_user'], 0777);

        $set = "username = :username, bio = :bio";
        $profile_folder = "../assets/uploads/{$_SESSION["id"]}/";
        $file = [];

        if (isset($files)) {
            $has_pic = empty($files["pic"]["name"]) ? false : true;

            if ($this->validateFiles($files, $has_pic)){
                $new_folder = $profile_folder . '/profile.dat';

                if ($has_pic) {
                    move_uploaded_file($files["pic"]["tmp_name"], $new_folder);
                    $data[":pic_path"] = $new_folder;
                    
                    $set .= ", pic_path = :pic_path";
                }
            } else {
                return false;
            }
        }

        $this->options = [
            "data" => $data,
            "entity" => "user",
            "conditional" => "ID_user = :ID_user",
            "set" => $set
        ];

        $this->db->update($this->options);
        return true;
    }

    /**
    * Função para validar arquivos antes de upar
    *
    * @param array $files
    * @return boolean
    * @author Ryan
    */
    public function validateFiles($files, $has_pic = true){
        // Validate pic
        if ($has_pic) {
            if (!in_array($files["pic"]["type"], ["image/png", "image/jpg", "image/jpeg"])){
                (new View("Sua foto de perfil deve ser uma imagem!"))->warning();
                return false;
            } else if ($files["pic"]["size"] > 1024000){
                (new View("Sua foto de perfil deve ter no máximo 1mb!"))->warning();
                return false;
            }
        }
        
        return true;
    }
}
?>