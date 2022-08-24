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
        $data[':post_content'] = str_replace("<scr", "&#60;scr", $data[':post_content']);
        $data[':post_title'] = str_replace("<", "&#60;", $data[':post_title']);
        $data[":ID_user_FK"] = $_SESSION["id"];

        $this->options = [
            "all" => false,
            "fields" => "*",
            "entity" => "post",
            "data" => $data,
            "conditional" => "post_title = :post_title"
        ];

        if (strlen($data[":post_title"]) > 150) {
            (new View("O título da postagem deve ter menos de 150 caracteres!"))->warning();
            return false;
        }


        if ($this->validateFiles($files)){
            $hash = hash('ripemd160', $data[":post_title"] . time());

            $game_folder = "../games/{$_SESSION["id"]}/{$hash}/";
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
            $fields = "post_title, post_content, language, ID_user_FK, post_files";

            $this->db->insert("post", $data, $fields);
            $this->createZip($game_folder, $file);
        } else {
            return false;
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
        $post = $this->getPost($data[":ID_post"]);
        $data[':post_content'] = str_replace("<scr", "&#60;scr", $data[':post_content']);
        $data[':post_title'] = str_replace("<", "&#60;", $data[':post_title']);

        $set = "post_title = :post_title, post_content = :post_content, language = :language";

        $current = $post['post_files'];
        $file = [];

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
            } else {
                return false;
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
            "has_html" => false,
            "especial" => false
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
                        if (in_array($files["source"]["type"][$key], ["application/octet-stream", "application/bat"])) {
                            (new View("O arquivo {$files["source"]["name"][$key]} não é suportado!"))->warning();
                            return false;
                        } else {
                            $options['especial'] = true;
                        }
                }
            }

            // Verifica se possui um arquivo index.html
            if (!$options["has_html"] && !$options['especial']){
                (new View("Você deve ter um arquivo index!"))->warning();
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
    * @param number
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
    * Função para selecionar histórico de postagens do usuário
    *
    * @param string
    * @param string
    * @param number
    * @return array
    * @author Ryan
    */
    public function history($column, $order, $id){
        // $order = ASC|DESC

        $this->options = [
            "all" => true,
            "fields" => "*",
            "entity" => "post",
            "data" => [":ID_user_FK" => $id],
            "conditional" => "ID_user_FK = :ID_user_FK",
            "custom" => "ORDER BY {$column} {$order}"
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
        if ($this->zip->open($dir . 'source_code.zip', ZipArchive::CREATE) === TRUE) {

            foreach($files as $filename) {
                $this->zip->addFile($dir.$filename);
            }

            $this->zip->close();
        }
    }
}
?>