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

        try {
            if (!$this->request->getData('consent')) {
                throw new Exception('null consent');
            }
            if (strlen($this->request->getData('consent')) < 8) {
                throw new Exception('password min');
            }

            $users = $this->getTableLocator()->get('Users');
            $user = $users->newEntity([
                "name" => $this->request->getData('name'),
                "username" => $this->request->getData('username'),
                "password" => hash("sha512", $this->request->getData('password')),
                "email" => $this->request->getData('email'),
                "consent" => $this->request->getData('consent'),
            ]);

            if ($users->save($user)) {
                $response = $response->withStringBody(json_encode(['message' => 'Tudo certo por aqui!']));
            } else {
                $response = $response->withStringBody(json_encode(['message' => 'Tudo errado por aqui!']));
            };
        } catch (Exception $error) {            
            if (str_contains($error->getMessage(), "for key 'users.email'")) {
                $response = $response->withStringBody(json_encode(['message' => 'Já existe um usuário com este email!']));
            } else if (str_contains($error->getMessage(), "for key 'users.username'")) {
                $response = $response->withStringBody(json_encode(['message' => 'Já existe um usuário com este nick!']));
            } else if (str_contains($error->getMessage(), "null consent")) {
                $response = $response->withStringBody(json_encode(['message' => 'Aceite os termos de uso!']));
            } else if (str_contains($error->getMessage(), "password min")) {
                $response = $response->withStringBody(json_encode(['message' => 'Sua senha deve ter no mínimo 8 caracteres!']));
            } else {
                $response = $response->withStringBody(json_encode(['message' => 'Oops, ocorreu um problema, tente novamente!']));
            }

            $response = $response->withStatus(400);
        }

        return $response;
    }
}
