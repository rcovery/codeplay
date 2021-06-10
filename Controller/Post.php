<?php
require_once(dirname(__FILE__) . "/../Model/DB.php");
require_once(dirname(__FILE__) . "/../pages/message.php");

class Post{
    private $db;
    private $options;
    private $zip;
    
    public function __construct(){
        $this->db = new Database;
        $this->zip = new ZipArchive;
    }
    
    /**
    * Função para criar uma postagem no banco de dados
    *
    * @param array $data
    * @return boolean
    * @author Ryan
    */
    public function createPost($data, $files){
        str_replace("<", "&#60;", $data[':post_content']);

        $content = $data[":post_content"];
        unset($data[":post_content"]);

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "post",
            "data" => $data,
            "conditional" => "post_title = :post_title"
        ];

        $result = $this->db->select($this->options);

        $data[":post_content"] = $content;

        if (isset($result['post_title']) && $result['post_title'] == $data[':post_title']){
            (new View("Já existe uma postagem com este título"))->warning();
            return false;
        }

        if (strlen($data[":post_title"]) > 150) {
            (new View("O título da postagem deve ter menos de  150 caracteres!"))->warning();
            return false;
        }
        
        $data[":ID_user_FK"] = $_SESSION["id"];

        if ($this->validateFiles($files)){
            $game_folder = "../games/{$_SESSION["id"]}/{$data[":post_title"]}/";
            $file = [];

            if (!file_exists("../games")) mkdir("../games", 0777);
            mkdir($game_folder . "thumb/", 0777, true);

            $new_path = $game_folder . "thumb/thumbnail.dat";
            move_uploaded_file($files["thumb"]["tmp_name"], $new_path);

            foreach ($files["source"]["name"] as $key=>$value){
                $new_path = $game_folder . "{$files["source"]["name"][$key]}";
                array_push($file, $files["source"]["name"][$key]);
                move_uploaded_file($files["source"]["tmp_name"][$key], $new_path);
            }
            $data[":post_files"] = $game_folder;
            $fields = "post_title, post_content, ID_user_FK, post_files";

            $this->db->insert("post", $data, $fields);
            $this->createZip($game_folder, $file);
        }

        return true;
    }

    /**
    * Função para atualizar postagem no banco de dados
    *
    * @param array $data
    * @param array $files
    * @return boolean
    * @author Ryan
    */
    public function updatePost($data, $files = null){
        str_replace("<", "&#60;", $data[':post_content']);

        $set = "post_title = :post_title, post_content = :post_content";
        $game_folder = "../games/{$_SESSION["id"]}/";
        $current = $game_folder . $data["original_title"] . "/";
        $file = [];

        if ($data["original_title"] != $data[":post_title"]) {
            $new_folder = $game_folder . $data[":post_title"];
            rename(dirname(__FILE__) . "/$current", dirname(__FILE__) . "/$new_folder/");

            $current = "../games/{$_SESSION["id"]}/{$data[":post_title"]}/";
            $data[":post_files"] = $current;
            $set .= ", post_files = :post_files";
        }

        if (isset($files)) {
            $has_thumb = !empty($files["thumb"]["name"]) ? true : false;
            $has_files = !empty($files["source"]["name"][0]) ? true : false;

            if ($this->validateFiles($files, $has_thumb, $has_files)){

                if ($has_thumb) {
                    $new_path = $current . "/thumb/thumbnail.dat";
                    move_uploaded_file($files["thumb"]["tmp_name"], $new_path);
                }
                if ($has_files) {
                    exec("rm -rf {$current}/*.*");
                    
                    foreach ($files["source"]["name"] as $key=>$value){
                        $new_path = $current . "/{$files["source"]["name"][$key]}";
                        array_push($file, $files["source"]["name"][$key]);
                        move_uploaded_file($files["source"]["tmp_name"][$key], $new_path);
                    }

                    $this->createZip($current, $file);
                }
            }
        }

        unset($data["edit"]);
        unset($data["original_title"]);

        $this->options = [
            "data" => $data,
            "entity" => "post",
            "conditional" => "ID_post = :ID_post",
            "set" => $set
        ];

        $this->db->update($this->options);
    }

    /**
    * Função para validar arquivos antes de upar
    *
    * @param array $files
    * @return boolean
    * @author Ryan
    */
    public function validateFiles($files, $has_thumb = true, $has_files = true){
        $options = [
            "has_html" => false
        ];

        // Validate thumb
        if ($has_thumb) {
            if (!in_array($files["thumb"]["type"], ["image/png", "image/jpg", "image/jpeg"])){
                (new View("Sua thumb deve ser uma imagem!"))->warning();
                return false;
            } else if ($files["thumb"]["size"] > 1024000){
                (new View("Sua thumb deve ter no máximo 1mb!"))->warning();
                return false;
            }
        }

        // Validate sources
        if ($has_files) {
            foreach ($files["source"]["name"] as $key=>$value) {
                // Filtrar arquivos do game
                switch ($files["source"]["type"][$key]) {
                    case "image/png":
                    case "image/jpg":
                    case "image/jpeg":
                        if ($files["source"]["size"][$key] > 1024000){
                            (new View("Arquivos de imagem devem ter no máximo 1mb!"))->warning();
                            return false;
                        }
                        break;
                    case "text/html":
                        if ($files["source"]["name"][$key] == "index.html") $options["has_html"] = true;

                        if ($files["source"]["size"][$key] > 51200){
                            (new View("Arquivos html devem ter no máximo 50kb!"))->warning();
                            return false;
                        }
                        break;
                    case "text/javascript":
                        if ($files["source"]["size"][$key] > 51200){
                            (new View("Arquivos javascript devem ter no máximo 50kb!"))->warning();
                            return false;
                        }
                        break;
                    case "text/css":
                        if ($files["source"]["size"][$key] > 51200){
                            (new View("Arquivos css devem ter no máximo 50kb!"))->warning();
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
            ":post_title" => "%" . $word . "%"
        ];

        $this->options = [
            "entity" => "post",
            "data" => $data,
            "conditional" => "post_title LIKE :post_title"
        ];

        $result = $this->db->findByName($this->options);

        return $result;
    }

    /**
    * Função para adicionar visualizações
    *
    * @param string
    * @author Ryan
    */
    public function view($id){
        $data = [
            ":ID_post" => $id
        ];

        $this->options = [
            "data" => $data,
            "entity" => "post",
            "conditional" => "ID_post = :ID_post",
            "set" => "post_views = post_views + 1"
        ];

        $this->db->update($this->options);
    }

    /**
    * Função para selecionar jogos para o showcase
    *
    * @param string
    * @param string
    * @return array
    * @author Ryan
    */
    public function showcase($column, $order, $limit = 10){
        // $order = ASC|DESC

        $this->options = [
            "all" => true,
            "fields" => "*",
            "entity" => "post",
            "custom" => "ORDER BY {$column} {$order} LIMIT {$limit}"
        ];

        $result = $this->db->select($this->options);

        return $result;
    }

    /**
    * Função para selecionar a postagem pelo ID
    *
    * @param string
    * @return array
    * @author Ryan
    */
    public function getPost($ID_post){
        $data[":ID_post"] = $ID_post;

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "post",
            "data" => $data,
            "conditional" => "ID_post = :ID_post"
        ];

        $result = $this->db->select($this->options);

        return $result;
    }

    /**
    * Função para gerar arquivo de download
    *
    * @param string
    * @param array
    * @return boolean
    * @author Ryan
    */
    public function createZip($dir, $files) {
        echo "init";
        if ($this->zip->open($dir . 'source_code.zip', ZipArchive::CREATE) === TRUE) {
            echo "create zip<br>";

            foreach($files as $filename) {
                $this->zip->addFile($dir.$filename);
            }

            $this->zip->close();
        }
        echo "endzip";
    }
}
?>