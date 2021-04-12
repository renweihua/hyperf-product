<?php

use think\migration\Migrator;
use think\migration\db\Column;

class QuestionBanks extends Migrator
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
    // 题库表
    public function change()
    {
        $this->table('question_banks', ['engine' => 'Innodb'])->setComment('题库表')
            ->setId('question_id')->setPrimaryKey('question_id')
            ->addColumn('question_name', 'string', ['limit' => 200, 'default' => '', 'comment' => '问题标题'])
            ->addColumn(Column::boolean('question_type')->setUnsigned()->setDefault(0)->setComment('题库类型：0：选择题；1：判断题'))
            // 1.正确；0.错误
            ->addColumn('question_answer', 'string', ['limit' => 200, 'default' => '', 'comment' => '问题答案【多选题的话就是 , 拼接】【判断题就直接存数字】'])
            ->addColumn(Column::boolean('is_delete')->setUnsigned()->setDefault(0)->setComment('是否删除：1：删除；0：正常'))
            ->addColumn(Column::integer('create_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
            ->addColumn(Column::integer('update_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
            ->addIndex('question_type')
            ->addIndex('is_delete')
            ->create();

        $this->table('question_options', ['engine' => 'Innodb'])->setComment('题库的选项表')
            ->setId('option_id')->setPrimaryKey('option_id')
            ->addColumn(Column::integer('question_id')->setUnsigned()->setDefault(0)->setComment('题库Id'))
            ->addColumn('option_ident', 'string', ['limit' => 200, 'default' => '', 'comment' => '选项标志（A.B.C）'])
            ->addColumn('option_name', 'string', ['limit' => 200, 'default' => '', 'comment' => '选项名称'])
            ->addColumn(Column::integer('option_sort')->setUnsigned()->setDefault(0)->setComment('排序'))
            ->addColumn(Column::boolean('is_right')->setUnsigned()->setDefault(0)->setComment('是否正确：0：否；1：是'))
            ->addIndex('question_id')
            ->addIndex('is_right')
            ->create();

        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        $this->table('question_users', ['engine' => 'Innodb'])->setComment('会员的答题记录')
            ->setId('id')->setPrimaryKey('id')
            ->addColumn(Column::integer('question_id')->setUnsigned()->setDefault(0)->setComment('题库Id'))
            ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
            ->addColumn('question_answer', 'string', ['limit' => 200, 'default' => '', 'comment' => '问题答案【多选题的话就是 , 拼接】'])
            ->addColumn(Column::boolean('answer_status')->setUnsigned()->setDefault(0)->setComment('此题是否答对：0.错误；1.正确'))
            ->addColumn(Column::integer('points_num')->setUnsigned()->setDefault(0)->setComment('积分奖励额度'))
            ->addColumn(Column::integer('create_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
            ->addColumn(Column::integer('update_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
            ->addIndex('question_id')
            ->addIndex('user_id')
            ->addIndex('answer_status')
            ->addIndex('create_time')
            ->create();
    }
}
