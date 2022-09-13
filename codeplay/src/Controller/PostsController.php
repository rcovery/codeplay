<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Exception;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        $this->Auth->allow(['viewPost']);
    }

    public function viewPost(): ?Response
    {
        // $this->set('title', 'Create User');
        return $this->render('create');
    }
    
    public function viewCreate(): ?Response
    {
        $this->set('title', 'Create Post');
        return $this->render('create');
    }

    public function create()
    {
        $flashMessage = 'Usuário criado com sucesso!';
        $flashElement = 'success';

        try {
            if (!$this->request->getData('consent')) {
                throw new Exception('null consent');
            }
            if (strlen($this->request->getData('password')) < 8) {
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

            if (!$users->save($user)) {
                $flashMessage = 'Tudo errado por aqui!';
                $flashElement = 'warning';
            } else {
                $this->Flash->set($flashMessage, [
                    "element" => $flashElement
                ]);
                return $this->redirect('/login');
            }
        } catch (Exception $error) {
            $flashElement = "error";

            if (str_contains($error->getMessage(), "for key 'users.email'")) {
                $flashMessage = 'Já existe um usuário com este email!';
            } else if (str_contains($error->getMessage(), "for key 'users.username'")) {
                $flashMessage = 'Já existe um usuário com este nick!';
            } else if (str_contains($error->getMessage(), "null consent")) {
                $flashMessage = 'Aceite os termos de uso!';
            } else if (str_contains($error->getMessage(), "password min")) {
                $flashMessage = 'Sua senha deve ter no mínimo 8 caracteres!';
            } else {
                $flashMessage = 'Oops, ocorreu um problema, tente novamente!';
            }
        }

        $this->Flash->set($flashMessage, [
            "key" => "flash",
            "element" => $flashElement
        ]);

        return $this->render();
    }
}
