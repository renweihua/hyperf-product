<?php

use think\migration\Migrator;
use think\migration\db\Column;

class PublicUsers extends Migrator
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
        $this->table('public_users', ['engine' => 'Innodb'])->setComment('公众号关注的会员表')
            ->setId('id')->setPrimaryKey('id')
            ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
            ->addColumn('openid', 'string', ['limit' => 200, 'default' => '', 'comment' => 'openid'])
            ->addColumn('unionid', 'string', ['limit' => 200, 'default' => '', 'comment' => 'unionid'])
            ->addColumn(Column::boolean('subscribe')->setUnsigned()->setDefault(0)->setComment('subscribe'))
            ->addColumn(Column::integer('create_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
            ->addColumn(Column::integer('update_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
            ->addIndex('unionid')
            ->addIndex('openid')
            ->addIndex('user_id')
            ->create();
    }
}
