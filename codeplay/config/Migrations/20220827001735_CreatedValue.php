<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatedValue extends AbstractMigration
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
        $this->table('users')->changeColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();

        $comments = $this->table('comments');
        $comments->addColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();
        
        $this->table('posts')->changeColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();
        $this->table('likes')->changeColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP'
        ])->update();
    }
}
