<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class UsersController extends AppController
{
    public function profile(): ?Response
    {
        $this->set('name', 'RCovery');
        return $this->render();
    }
}
