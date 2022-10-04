<?php
declare(strict_types=1);

namespace App\Test\TestCase;

use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * PostTest class
 */
class PostsTest extends TestCase
{
    use IntegrationTestTrait;

    protected function setUp(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1
                ]
            ]
        ]);
    }

    public function testCreateWithoutTitle()
    {
        $data = [
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Insira o título da sua postagem!', 'flash');
    }

    public function testCreateWithTitleMaxLength()
    {
        $data = [
            'post_title' => 'Test title Test title Test title Test title Test title Test title Test title Test title Test title Test title Test title Test title Test title Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('O título da postagem deve ter menos de 150 caracteres!', 'flash');
    }

    public function testCreateWithoutContent()
    {
        $data = [
            'post_title' => 'Test title',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Insira a descrição da sua postagem!', 'flash');
    }

    public function testCreateWithoutProgrammingLanguage()
    {
        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Insira a linguagem de programação do seu jogo!', 'flash');
    }

    public function testCreateWithoutFiles()
    {
        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('É necessário subir pelo menos um arquivo do jogo!', 'flash');
    }

    public function testCreateFileSize()
    {
        $file = new \Laminas\Diactoros\UploadedFile(
            '/path/to/test/file.pdf',
            123456789, // bytes
            \UPLOAD_ERR_OK,
            'attachment.pdf',
            'application/pdf'
        );

        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
            'attachments' => [
                0 => ['attachment' => $file]
            ]
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('O tamanho do arquivo é muito grande!', 'flash');
        $this->assertRedirect('/login');
    }
    public function testCreateFileMimetype()
    {
        $file = new \Laminas\Diactoros\UploadedFile(
            '/path/to/test/file.pdf',
            55000, // bytes
            \UPLOAD_ERR_OK,
            'attachment.pdf',
            'application/octet-stream'
        );

        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
            'attachments' => [
                0 => ['attachment' => $file]
            ]
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('O tipo de arquivo não é permitido!', 'flash');
    }

    public function testCreate()
    {
        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Postagem criada com sucesso!', 'flash');
    }

    public function testCreatePostUnauthenticated()
    {
        $this->session([]);

        $data = [
            'post_title' => 'Test title',
            'post_content' => 'Test post',
            'programming_language' => 'Lua',
        ];
        $this->post('/post/create', $data);

        $this->assertRedirect('/login');
    }

    public function testViewCreatePostUnauthenticated()
    {
        $this->session([]);
        $this->get('/post/create');

        $this->assertRedirect('/login');
    }

    public function testViewPost()
    {
        $this->get('/post/1');

        // $this->assertFlashMessage('Logado com sucesso!');
        // assert contains
    }

    public function testViewPostUnauthenticated()
    {
        $this->session([]);
        $this->get('/post/1');

        // $this->assertFlashMessage('Logado com sucesso!');
        // assert contains
    }
}
