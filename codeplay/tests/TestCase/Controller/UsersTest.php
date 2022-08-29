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

    /**
     * User Creation
     */
    public function testCreateWithoutConsent()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        
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

    public function testCreate()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        
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
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery',
            'password' => '123',
            'email' => 'rcovery2@test.com',
        ];
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains(utf8_encode('existe um usuário com este nick'));
    }

    public function testCreateDuplicatedEmail()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'name' => 'RCovery',
            'username' => 'rcovery2',
            'password' => '123',
            'email' => 'rcovery@test.com',
        ];
        $this->post('/user', $data);

        $this->assertResponseError();
        $this->assertResponseContains(utf8_encode('existe um usuário com este email'));
    }

    /**
     * User Login
     */
}
