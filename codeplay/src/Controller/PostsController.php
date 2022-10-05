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
        $flashMessage = 'Postagem criada com sucesso!';
        $flashElement = 'success';

        try {
            $title = htmlspecialchars($this->request->getData('title'));

            if (!$title) {
                throw new Exception('Insira o título da sua postagem!');
            }
            if (strlen($title) >= 150) {
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
                "title" => $title,
                "content" => $this->request->getData('content'),
                "programming_language" => $this->request->getData('programming_language'),
                "user_id" => $this->Auth->user()['id'],
                "" => $this->request->getData('consent'),
            ]);

            $post = $model->save($entity);
            if (!$post) {
                $flashMessage = 'Tudo errado por aqui!';
                $flashElement = 'warning';
            } else {
                $this->Flash->set($flashMessage, [
                    "element" => $flashElement
                ]);
                return $this->redirect("/post/$post->id");
            }
        } catch (Exception $error) {
            $flashElement = "error";
            $flashMessage = $error->getMessage();
        }

        $this->Flash->set($flashMessage, [
            "key" => "flash",
            "element" => $flashElement
        ]);

        return $this->render();
    }
}
