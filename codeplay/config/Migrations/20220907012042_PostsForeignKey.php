<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class PostsForeignKey extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('posts');
        $table->addIndex('user_id')
        ->addForeignKey('user_id', 'users', 'id')
        ->update();
    }
}
