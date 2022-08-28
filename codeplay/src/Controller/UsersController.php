<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Exception;

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
        $response = $this->response->withType('application/json');

        $users = $this->getTableLocator()->get('Users');
        $user = $users->newEntity([
            "name" => $this->request->getData('name'),
            "username" => $this->request->getData('username'),
            "password" => $this->request->getData('password'),
            "email" => $this->request->getData('email'),
        ]);

        try {
            if ($users->save($user)) {
                $response = $response->withStringBody(json_encode(['message' => 'Tudo certo por aqui!']));
            } else {
                $response = $response->withStringBody(json_encode(['message' => 'Tudo errado por aqui!']));
            };
        } catch (Exception $error) {            
            if (str_contains($error->getMessage(), "for key 'users.email'")) {
                $response = $response->withStringBody(json_encode(['message' => 'Já existe um player com este email!']));
            } else {
                $response = $response->withStringBody(json_encode(['message' => 'Oops, ocorreu um problema, tente novamente!']));
            }

            $response = $response->withStatus(400);
        }

        return $response;
    }
}
