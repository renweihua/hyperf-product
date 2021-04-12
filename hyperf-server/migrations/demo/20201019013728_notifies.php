<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Notifies extends Migrator
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
        if ($this->hasTable('notifies')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        $this->table('notifies', ['engine'=>'Innodb'])
             ->setComment('系统消息通知记录表')
             ->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('notify_id')
             ->setPrimaryKey('notify_id')
             ->addColumn(Column::integer('notify_type')->setUnsigned()->setDefault(0)->setComment('消息类型：0.系统消息；1.互动消息；2.业务消息'))
             ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
             ->addColumn(Column::integer('target_id')->setUnsigned()->setDefault(0)->setComment('目标Id(比如动态ID)'))
             ->addColumn(Column::boolean('target_type')->setUnsigned()->setDefault(0)->setComment('目标类型：1.动态；2.直播；3.档期；4.候选；5.关注'))
             // 仅限互动消息
             ->addColumn(Column::boolean('dynamic_type')->setUnsigned()->setDefault(0)->setComment('动态的类型：0.点赞；1.收藏；2.评论；3.分享；4.点赞评论'))
             ->addColumn(Column::integer('sender_id')->setUnsigned()->setDefault(0)->setComment('发送者Id'))
             ->addColumn(Column::boolean('sender_type')->setUnsigned()->setDefault(0)->setComment('发送者类型：0.系统通知（所有人）；1.指定角色'))
             ->addColumn(Column::boolean('user_identity')->setUnsigned()->setDefault(0)->setComment('身份：0：默认就是所有人；1：筹备者；2：婚庆人'))
             ->addColumn(Column::integer('wedding_role')->setUnsigned()->setDefault(0)->setComment('婚庆人的角色Id'))
             ->addColumn(Column::text('notify_content')->setComment('内容'))
             ->addColumn(Column::boolean('is_read')->setUnsigned()->setDefault(0)->setComment('是否已读：0：否；1：是'))
             ->addColumn(Column::integer('admin_id')->setUnsigned()->setDefault(0)->setComment('管理员Id'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addColumn(Column::boolean('filing_type')->setUnsigned()->setDefault(0)->setComment('订档状态类型：1.同意；2.拒绝；3.取消'))
             ->addIndex('user_id')
             ->addIndex('notify_type')
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
        $this->dropTable('notifies');
    }
}
