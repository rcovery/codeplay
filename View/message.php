<?php
class View
{
    private $message;
    
    public function __construct($message) {
        $this->message = $message;
    }
    
    public function warning(){
        $this->message = "
        <h1>{$this->message}</h1>
        ";

        $this->render();
    }

    public function render()
    {
        echo $this->message;
    }
}
?>