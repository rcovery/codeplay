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
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains('Aceite os termos');
    }

    public function testCreatePassword()
    {        
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery@test.com',
        ];
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains('Sua senha deve ter');
    }

    public function testCreate()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/user', $data);

        $this->assertResponseOk();
        $this->assertResponseContains('Tudo certo');
    }

    public function testCreateDuplicatedUser()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery2@test.com',
            'consent' => true
        ];
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains(json_encode(['message' => 'Já existe um usuário com este nick!']));
    }

    public function testCreateDuplicatedEmail()
    {
        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery2',
            'password' => '123',
            'email' => 'rcovery@test.com',
            'consent' => true
        ];
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains(json_encode(['message' => 'Já existe um usuário com este email!']));
    }

    /**
     * User Login
     */
    public function testLogin()
    {
        $data = [
            'password' => '1234',
            'username' => 'rcovery@test.com',
        ];
        $this->post('/login', $data);

        $this->assertResponseError();
        $this->assertResponseContains('Usuário ou senha incorretos!');
    }
}
