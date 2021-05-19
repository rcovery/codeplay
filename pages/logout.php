<?php
    include(dirname(__FILE__) . "/../Controller/Session.php");
    session_start();
    if ((new Session())->killSession()){
        header("location: ../index.php");
    }
?>