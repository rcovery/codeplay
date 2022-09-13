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
        $this->post('/create', $data);

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
        $this->post('/create', $data);

        $this->assertFlashMessage('Usuário criado com sucesso!', 'flash');
        $this->assertRedirect('/login');
    }

    public function testViewPostUnauthenticated()
    {
        $data = [
            'password' => '12345678',
            'username' => 'rcovery',
        ];
        $this->post('/login', $data);

        $this->assertFlashMessage('Logado com sucesso!');
        $this->assertRedirect('/');
    }

    public function testViewPost()
    {
        $data = [
            'password' => '12345678',
            'username' => 'rcovery',
        ];
        $this->post('/login', $data);

        $this->assertFlashMessage('Logado com sucesso!');
        $this->assertRedirect('/');
    }
}
