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

    /**
     * User Creation
     */
    public function testCreateWithoutConsent()
    {        
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery@test.com',
        ];
        $this->post('/create', $data);

        $this->assertFlashMessage('Aceite os termos de uso!', 'flash');
    }

    public function testCreatePassword()
    {        
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/create', $data);

        $this->assertFlashMessage('Sua senha deve ter no mínimo 8 caracteres!', 'flash');
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

    public function testCreateDuplicatedUser()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '12345678',
            'email' => 'rcovery2@test.com',
            'consent' => true
        ];
        $this->post('/create', $data);

        $this->assertFlashMessage('Já existe um usuário com este nick!', 'flash');
    }

    public function testCreateDuplicatedEmail()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery2',
            'password' => '12345678',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/create', $data);

        $this->assertFlashMessage('Já existe um usuário com este email!', 'flash');
    }

    /**
     * User Login
     */
    public function testLoginError()
    {
        $data = [
            'password' => '1234356784',
            'username' => 'rcovery',
        ];
        $this->post('/login', $data);

        $this->assertFlashMessage('Usuário ou senha incorretos!');
    }

    public function testLogin()
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
