<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Exception;

class PostsController extends AppController
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
        $userId = $this->Auth->user()['id'];

        if (empty($userId)) {
            return $this->redirect("/login");
        }

        $this->set('title', 'Create Post');
        return $this->render('create');
    }

    public function create()
    {
        if (empty($this->request->getData('title'))) {
            return $this->Flash->error('Insira o título da sua postagem!');
        }
        if (strlen($this->request->getData('title')) >= 150) {
            return $this->Flash->errorn('O título da postagem deve ter menos de 150 caracteres!');
        }
        if (empty($this->request->getData('content'))) {
            return $this->Flash->error('Insira a descrição da sua postagem!');
        }
        if (empty($this->request->getData('programming_language'))) {
            return $this->Flash->error('Insira a linguagem de programação do seu jogo!');
        }

        $userId = $this->Auth->user()['id'];
        $model = $this->getTableLocator()->get('Posts');
        $entity = $model->newEntity([
            "title" => $this->request->getData('title'),
            "content" => $this->request->getData('content'),
            "programming_language" => $this->request->getData('programming_language'),
            "file" => '', // TODO implement file and thumb upload
            "thumb" => '',
            "user_id" => $userId,
        ]);

        $post = $model->save($entity);

        if ($post) {
            $this->Flash->success('Postagem criada com sucesso!');
            return $this->redirect("/post/$post->id");
        }

        return $this->render();
    }

    /* private function isValidFile()
    {
        return true;
    } */
}
