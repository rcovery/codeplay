<?php
declare(strict_types=1);

namespace App\Test\TestCase;

use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * LikeTest class
 */
class LikesTest extends TestCase
{
    use IntegrationTestTrait;

    protected function setUp(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();
    }

    public function testLikePost()
    {        
        $this->post('/like/post/1');

        $this->assertResponseContains('liked!');
        $this->assertResponseOk();
    }

    public function testUnlikePost()
    {        
        $this->post('/like/post/1');

        $this->assertResponseContains('unliked!');
        $this->assertResponseOk();
    }

    public function testLikeUser()
    {        
        $this->post('/like/user/1');

        $this->assertResponseContains('unliked!');
        $this->assertResponseOk();
    }
    public function testUnlikeUser()
    {        
        $this->post('/like/user/1');

        $this->assertResponseContains('unliked!');
        $this->assertResponseOk();
    }
}
