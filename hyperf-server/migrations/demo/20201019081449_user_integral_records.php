<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UserIntegralRecords extends Migrator
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
        if ($this->hasTable('user_integral_records')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        $this->table('user_integral_records', ['engine'=>'Innodb'])
             ->setComment('会员积分变动记录表')->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('record_id')
             ->setPrimaryKey('record_id')
             ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
             ->addColumn(Column::integer('change_money')->setDefault(0)->setComment('变动额度'))
             ->addColumn(Column::integer('surplus_money')->setDefault(0)->setComment('变动之后剩余的额度'))
             ->addColumn('log_describe', 'string', ['limit' => 200, 'default' => '', 'comment' => '描述'])
             ->addColumn(Column::integer('admin_id')->setUnsigned()->setDefault(0)->setComment('管理员Id'))
             ->addColumn('admin_remarks', 'string', ['limit' => 200, 'default' => '', 'comment' => '管理员备注'])
             ->addColumn(Column::boolean('change_type')->setUnsigned()->setDefault(0)->setComment('变动类型：0：发布动态；1：回复评论；2.订档；3.被订档'))
             ->addColumn(Column::boolean('operation_type')->setUnsigned()->setDefault(1)->setComment('操作类型：0：撤回操作；1：正常操作'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addColumn(Column::integer('relation_id')->setUnsigned()->setDefault(0)->setComment('关联Id'))
             ->addIndex('user_id')
             ->addIndex('change_type')
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
        $this->dropTable('user_integral_logs');
    }
}
