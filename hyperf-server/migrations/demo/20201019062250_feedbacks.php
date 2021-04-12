<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Feedbacks extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        if ($this->hasTable('feedbacks')) return;
        $this->table('feedbacks', ['engine'=>'Innodb'])
             ->setComment('意见反馈表')->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('feedback_id')
             ->setPrimaryKey('feedback_id')
             ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
             ->addColumn('feedback_content', 'string', ['limit' => 500, 'default' => '', 'comment' => '反馈内容'])
             ->addColumn('feedback_images', 'string', ['limit' => 300, 'default' => '', 'comment' => '反馈图片'])
             ->addColumn(Column::integer('admin_id')->setUnsigned()->setDefault(0)->setComment('操作人'))
             ->addColumn('admin_remarks', 'string', ['limit' => 200, 'default' => '', 'comment' => '管理员备注'])
             ->addColumn(Column::boolean('is_check')->setUnsigned()->setDefault(0)->setComment('反馈状态：0.待处理；1.已处理；2.忽略'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addIndex('user_id')
             ->addIndex('is_check')
             ->create();
    }

    /**
     * Migrate Up.
     */
    public function up()
    {

    }
    
    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('feedbacks');
    }
}
