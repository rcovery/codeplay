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
        $this->set('title', 'Create Post');
        return $this->render('create');
    }

    public function create()
    {
        try {
            if (empty($this->request->getData('title'))) {
                throw new Exception('Insira o título da sua postagem!');
            }
            if (strlen($this->request->getData('title')) >= 150) {
                throw new Exception('O título da postagem deve ter menos de 150 caracteres!');
            }
            if (!$this->request->getData('content')) {
                throw new Exception('Insira a descrição da sua postagem!');
            }
            if (!$this->request->getData('programming_language')) {
                throw new Exception('Insira a linguagem de programação do seu jogo!');
            }

            $model = $this->getTableLocator()->get('Posts');
            $entity = $model->newEntity([
                "title" => $this->request->getData('title'),
                "content" => $this->request->getData('content'),
                "programming_language" => $this->request->getData('programming_language'),
                "user_id" => $this->Auth->user()['id'],
            ]);

            $post = $model->save($entity);
            if (!$post) {
                $this->Flash->set('Tudo errado por aqui!', [
                    "element" => 'warning'
                ]);
            } else {
                $this->Flash->set('Postagem criada com sucesso!', [
                    "element" => 'success'
                ]);
                return $this->redirect("/post/$post->id");
            }
        } catch (Exception $error) {
            $this->Flash->set($error->getMessage(), [
                "element" => "error"
            ]);
        }

        return $this->render();
    }

    /* private function isValidFile()
    {
        return true;
    } */
}
