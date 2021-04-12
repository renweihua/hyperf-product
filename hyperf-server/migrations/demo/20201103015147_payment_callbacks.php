<?php

use think\migration\Migrator;
use think\migration\db\Column;

class PaymentCallbacks extends Migrator
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
        if ($this->hasTable('payment_callbacks')) return;
        $this->table('payment_callbacks', ['engine' => 'Innodb'])
             ->setComment('第三方支付回调记录表[禁止被删除]')->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('callback_id')
             ->setPrimaryKey('callback_id')
             ->addColumn('callback_person', 'string', ['limit' => 200, 'default' => '', 'comment' => '第三方平台：alipay - 支付宝,wechat - 微信,Wechat applet - 微信小程序'])
             ->addColumn(Column::integer('payment_type')->setUnsigned()->setDefault(0)->setComment('支付类型：0.会员充值'))
             ->addColumn('order_no', 'string', ['limit' => 100, 'default' => '', 'comment' => '订单号'])
             ->addColumn('payment_callback', 'string', ['limit' => 2000, 'default' => '', 'comment' => '支付回调信息'])
             ->addColumn(Column::string('created_ip', 20)->setDefault('')->setComment('创建时的IP'))
             ->addColumn(Column::boolean('is_delete')->setUnsigned()->setDefault(0)->setComment('是否删除：1：删除；0：正常'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addIndex('order_no')
             ->addIndex('payment_type')
             ->addIndex('is_delete')
             ->create();
    }
}
