<?php
declare(strict_types=1);

namespace App\Test\TestCase;

use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * UserTest class
 */
class UsersTest extends TestCase
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

    public function testCreateWithoutFile()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '12345678',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Usuário criado com sucesso!', 'flash');
        $this->assertRedirect('/login');
    }

    public function testCreateFileSize()
    {
        $file = new \Laminas\Diactoros\UploadedFile(
            '/path/to/test/file.pdf',
            1234567, // bytes
            \UPLOAD_ERR_OK,
            'attachment.pdf',
            'application/pdf'
        );

        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '12345678',
            'email' => 'rcovery@test.com',
            'consent' => true,
            'attachments' => [
                0 => ['attachment' => $file]
            ]
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Usuário criado com sucesso!', 'flash');
        $this->assertRedirect('/login');
    }
    public function testCreateFileMimetype()
    {
        $file = new \Laminas\Diactoros\UploadedFile(
            '/path/to/test/file.pdf',
            55000, // bytes
            \UPLOAD_ERR_OK,
            'attachment.pdf',
            'application/pdf'
        );

        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '12345678',
            'email' => 'rcovery@test.com',
            'consent' => true,
            'attachments' => [
                0 => ['attachment' => $file]
            ]
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Usuário criado com sucesso!', 'flash');
        $this->assertRedirect('/login');
    }

    public function testCreate()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '12345678',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Usuário criado com sucesso!', 'flash');
        $this->assertRedirect('/login');
    }

    public function testCreatePostUnauthenticated()
    {
        $this->session([]);

        $data = [
            'password' => '12345678',
            'username' => 'rcovery',
        ];
        $this->post('/post/create', $data);

        $this->assertFlashMessage('Logado com sucesso!');
        $this->assertRedirect('/login');
    }

    public function testViewPost()
    {
        $data = [
            'password' => '12345678',
            'username' => 'rcovery',
        ];
        $this->post('/post/1', $data);

        $this->assertFlashMessage('Logado com sucesso!');
    }

    public function testViewPostUnauthenticated()
    {
        $this->session([]);
        
        $data = [
            'password' => '12345678',
            'username' => 'rcovery',
        ];
        $this->post('/post/1', $data);

        $this->assertFlashMessage('Logado com sucesso!');
    }
}
