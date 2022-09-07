<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class LikesForeignKey extends AbstractMigration
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
        $table = $this->table('likes');
        $table
        ->addIndex('user_id')
        ->addIndex('post_id')
        ->addIndex('comment_id')
        ->addForeignKey('user_id', 'users', 'id')
        ->addForeignKey('post_id', 'posts', 'id')
        ->addForeignKey('comment_id', 'comments', 'id')
        ->update();
    }
}
