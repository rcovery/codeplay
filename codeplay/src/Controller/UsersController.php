<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class UsersController extends AppController
{
    public function profile(): ?Response
    {
        return $this->render();
    }

    public function view(): ?Response
    {
        return $this->render();
    }

    public function create()
    {
        $users = $this->getTableLocator()->get('Users');
        $user = $users->newEntity([
            "name" => $this->request->getData('name'),
            "username" => $this->request->getData('username'),
            "password" => $this->request->getData('password'),
            "email" => $this->request->getData('email'),
        ]);
        if ($users->save($user)) {
            $this->set(['message' => 'Tudo certo por aqui!']);
        } else {
            $this->set(['message' => 'Tudo errado por aqui!']);
        };

        $this->viewBuilder()->setOption('serialize', true);
        $this->RequestHandler->renderAs($this, 'json');
    }
}
