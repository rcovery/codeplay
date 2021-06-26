<?php
require_once(dirname(__FILE__) . "/../Model/DB.php");

class Likes{
    private $db;
    private $options;
    
    public function __construct(){
        $this->db = new Database;
    }

    /**
    * Função para verificar se a postagem já foi curtida
    *
    * @param string
    * @param string
    * @return boolean
    * @author Ryan
    */
    public function isLiked($id_post, $id_user){
        $data = [
            ":ID_post_FK" => $id_post,
            ":ID_user_FK" => $id_user
        ];

        $this->options = [
            "all" => false,
            "fields" => "*",
            "data" => $data,
            "entity" => "likes",
            "conditional" => "ID_post_FK = :ID_post_FK AND ID_user_FK = :ID_user_FK"
        ];

        $result = $this->db->select($this->options);

        if (!isset($result)) return false;

        return true;
    }

    /**
    * Função para curtir
    *
    * @param string
    * @param string
    * @return boolean
    * @author Ryan
    */
    public function like($id_post, $id_user){
        $data = [
            ":ID_post_FK" => $id_post,
            ":ID_user_FK" => $id_user
        ];


        if ($this->isLiked($id_post, $id_user)) {
            $this->options = [
                "data" => [":ID_post" => $id_post],
                "entity" => "post",
                "conditional" => "ID_post = :ID_post",
                "set" => "post_likes = post_likes - 1"
            ];

            $this->db->update($this->options);
            $this->db->delete([
                "entity" => "likes",
                "conditional" => "ID_post_FK = :ID_post_FK AND ID_user_FK = :ID_user_FK",
                "data" => $data
            ]);
        } else {
            $this->options = [
                "data" => [":ID_post" => $id_post],
                "entity" => "post",
                "conditional" => "ID_post = :ID_post",
                "set" => "post_likes = post_likes + 1"
            ];
            
            $this->db->update($this->options);
            $this->db->insert("likes", $data, "ID_post_FK, ID_user_FK");
        }

        return true;
    }
}
?>