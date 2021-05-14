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
            <p class='warning message'>{$this->message}</p>
        </div>
        ";

        $this->render();
    }

    public function success(){
        $this->message = "
        <div class='message_box' onclick='destroy_message(this)'>
            <p class='success message'>{$this->message}</p>
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