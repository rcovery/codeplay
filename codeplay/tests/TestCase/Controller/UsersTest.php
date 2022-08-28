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

    public function testCreate()
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

        $this->assertResponseOk();
        $this->assertResponseContains('Tudo certo');
    }
}
