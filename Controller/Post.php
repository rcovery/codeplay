<?php
require(dirname(__FILE__) . "/../Model/DB.php");
include(dirname(__FILE__) . "/../pages/message.php");

class Post{
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
    public function createPost($data, $files){
        foreach(array_values($data) as $index=>$value){
            if (gettype($index) != "integer"){
                $data[$index] = filter_var($value, FILTER_SANITIZE_STRING);
            }
        }

        $this->select_options = [
            "all" => false,
            "id" => "ID_post",
            "entity" => "post",
            "data" => $data,
            "conditional" => ["post_title"]
        ];

        $result = $this->db->select($this->select_options);

        if ($result['post_title'] == $data['post_title']){
            (new View("Já existe uma postagem com este título"))->warning();
            return false;
        }

        if (strlen($data["post_title"]) > 150) {
            (new View("O título da postagem deve ter menos de  150 caracteres!"))->warning();
            return false;
        }
        
        $data["ID_user_FK"] = $_SESSION["id"];

        if ($this->validateFiles($files)){
            $game_folder = "../games/{$_SESSION["id"]}/{$data["post_title"]}/";

            if (!file_exists($game_folder)) mkdir($game_folder, 0777, true);

            $new_path = $game_folder . "{$files["thumb"]["name"]}";
            move_uploaded_file($files["thumb"]["tmp_name"], $new_path);
            $data["post_thumb"] = $new_path;

            foreach ($files["source"]["name"] as $key=>$value){
                $new_path = $game_folder . "{$files["source"]["name"][$key]}";
                move_uploaded_file($files["source"]["tmp_name"][$key], $new_path);
            }
            $data["post_files"] = $game_folder;

            $this->db->insert("post", $data);
        }

        return true;
    }

    /**
    * Função para validar arquivos antes de upar
    *
    * @param array $files
    * @return boolean
    * @author Ryan
    */
    public function validateFiles($files){
        $options = [
            "has_html" => false
        ];

        // Validate thumb
        if (!in_array($files["thumb"]["type"], ["image/png", "image/jpg", "image/jpeg"])){
            (new View("Sua thumb deve ser uma imagem!"))->warning();
            return false;
        } else if ($files["thumb"]["size"] > 40960){
            (new View("Sua thumb deve ter no máximo 40kb!"))->warning();
            return false;
        }

        // Validate sources
        foreach ($files["source"]["name"] as $key=>$value) {
            // Filtrar arquivos do game
            switch ($files["source"]["type"][$key]) {
                case "image/png":
                case "image/jpg":
                case "image/jpeg":
                    if ($files["source"]["size"][$key] > 40960){
                        (new View("Arquivos de imagem devem ter menos que 40kb!"))->warning();
                        return false;
                    }
                    break;
                case "text/html":
                    if ($files["source"]["name"][$key] == "index.html") $options["has_html"] = true;

                    if ($files["source"]["size"][$key] > 20480){
                        (new View("Arquivos html devem ter menos que 20kb!"))->warning();
                        return false;
                    }
                    break;
                case "text/javascript":
                    if ($files["source"]["size"][$key] > 10240){
                        (new View("Arquivos javascript devem ter menos que 10kb!"))->warning();
                        return false;
                    }
                    break;
                case "text/css":
                    if ($files["source"]["size"][$key] > 15360){
                        (new View("Arquivos css devem ter menos que 15kb!"))->warning();
                        return false;
                    }
                    break;
                default:
                    (new View("O arquivo {$files["source"]["name"][$key]} não é suportado!"))->warning();
                    return false;
            }
        }

        // Verifica se possui um arquivo index.html
        if (!$options["has_html"]){
            (new View("Você deve ter um arquivo index.html!"))->warning();
            return false;
        }
        
        return true;
    }

    /**
    * Função para buscar posts
    *
    * @param string
    * @return array
    * @author Ryan
    */
    public function search($word){
        $data = [
            ":post_title" => $word
        ];

        $this->select_options = [
            "entity" => "post",
            "data" => $data,
            "conditional" => "post_title = :post_title"
        ];

        $result = $this->db->findByName($this->select_options);

        var_dump($result);
    }
}
?>