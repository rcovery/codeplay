<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class UpdatedValue extends AbstractMigration
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
        $this->table('users')->changeColumn('updated', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();

        $comments = $this->table('comments');
        $comments->addColumn('updated', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();
        
        $this->table('posts')->changeColumn('updated', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();
    }
}