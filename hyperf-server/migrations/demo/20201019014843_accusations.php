<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Accusations extends Migrator
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
        if ($this->hasTable('accusations')) return;
        $this->table('accusations', ['engine'=>'Innodb'])
             ->setComment('举报记录表')
             ->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('id')
             ->setPrimaryKey('id')
             ->addColumn(Column::integer('accusation_type')->setUnsigned()->setDefault(0)->setComment('举报类型：0.会员；1.动态'))
             ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('举报人（会员Id）'))
             ->addColumn(Column::integer('accusation_id')->setUnsigned()->setDefault(0)->setComment('被举报的会员Id'))
             ->addColumn(Column::integer('dynamic_id')->setUnsigned()->setDefault(0)->setComment('被举报的动态Id'))
             ->addColumn('accusation_images', 'string', ['limit' => 300, 'default' => '', 'comment' => '附件图'])
             ->addColumn(Column::text('accusation_content')->setComment('内容'))
             ->addColumn(Column::boolean('is_handle')->setUnsigned()->setDefault(0)->setComment('是否已处理：0：否；1：是'))
             ->addColumn(Column::integer('admin_id')->setUnsigned()->setDefault(0)->setComment('操作人'))
             ->addColumn('admin_remarks', 'string', ['limit' => 200, 'default' => '', 'comment' => '管理员备注'])
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addIndex('accusation_type')
             ->addIndex('accusation_id')
             ->addIndex('is_handle')
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
        $this->dropTable('accusation_users');
    }
}
