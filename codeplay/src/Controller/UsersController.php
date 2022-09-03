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
        $this->Auth->allow(['viewCreate', 'create']);
    }
    public function profile(): ?Response
    {
        $this->set('title', 'Profile');
        return $this->render();
    }

    public function viewLogin(): ?Response
    {
        $this->set('title', 'Login');
        return $this->render('login');
    }

    public function login(): ?Response
    {
        $userInstance = $this->getTableLocator()->get('Users')->find();

        $user = $userInstance->where([
                'username' => $this->request->getData('username'),
                'password' => hash("sha512", $this->request->getData('password'))
            ])->select(['name', 'username', 'email'])
            ->first();

        if (!$user) {
            $this->Flash->error('Usuário ou senha incorretos!');
        }
        
        $this->Flash->set('Logado com sucesso!');

        $this->Auth->setUser($user);
        return $this->render();
    }

    public function logout(): ?Response
    {
        return $this->redirect($this->Auth->logout());
    }

    public function viewCreate(): ?Response
    {
        $this->set('title', 'Create User');
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
