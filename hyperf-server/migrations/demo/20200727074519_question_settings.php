<?php

use think\migration\Migrator;
use think\migration\db\Column;

class QuestionSettings extends Migrator
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
        $this->table('question_settings', ['engine' => 'Innodb'])->setComment('答题设置表')
            ->setId('id')->setPrimaryKey('id')
            ->addColumn('key', 'string', ['limit' => 200, 'default' => '', 'comment' => '设置项标示'])
            ->addColumn('describe', 'string', ['limit' => 200, 'default' => '', 'comment' => '设置项描述'])
            ->addColumn('values', 'string', ['limit' => 200, 'default' => '', 'comment' => '内容'])
            ->addColumn(Column::boolean('is_delete')->setUnsigned()->setDefault(0)->setComment('是否删除：1：删除；0：正常'))
            ->addColumn(Column::integer('create_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
            ->addColumn(Column::integer('update_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
            ->addIndex('is_delete')
            ->create();
    }
}
