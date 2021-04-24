<?php
class Session{ 
    /**
    * Função para carregar uma sessão já existente
    *
    * @return boolean
    * @author Ryan
    */
    public function loadSession(){
        if (!isset($_SESSION["user"]) || !isset($_SESSION["id"])){
            return false;
        }
        if (time() - $_SESSION["last_activity"] > (1 * 3600)){
            $this->killSession();
            return false;
        }
        
        return true;
    }

    /**
    * Função para destruir uma sessão já existente
    *
    * @return boolean
    * @author Ryan
    */
    public function killSession(){
        session_unset();
        session_destroy();
        
        return true;
    }
}
?>