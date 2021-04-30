<?php
class View
{
    private $message;
    
    public function __construct($message) {
        $this->message = $message;
    }
    
    public function warning(){
        $this->message = "
        <div class='message_box' onclick='destroy_message(this)'>
            <h1 class='warning message'>{$this->message}</h1>
        </div>
        ";

        $this->render();
    }

    public function render()
    {
        echo $this->message;
    }
}
?>