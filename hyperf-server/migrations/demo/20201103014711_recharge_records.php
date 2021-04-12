<?php

use think\migration\Migrator;
use think\migration\db\Column;

class RechargeRecords extends Migrator
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
        if ($this->hasTable('recharge_records')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        $this->table('recharge_records', ['engine'=>'Innodb'])
             ->setComment('充值记录表')->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('record_id')
             ->setPrimaryKey('record_id')
             ->addColumn(Column::integer('user_id')->setUnsigned()->setDefault(0)->setComment('会员Id'))
             ->addColumn(Column::boolean('recharge_type')->setUnsigned()->setDefault(0)->setComment('充值方式：0.微信；1.支付宝'))
             ->addColumn('order_no', 'string', ['limit' => 100, 'default' => '', 'comment' => '订单号'])
             ->addColumn(Column::decimal('recharge_money', 10, 2)->setUnsigned()->setDefault(0)->setComment('充值金额'))
             ->addColumn(Column::integer('pay_time')->setUnsigned()->setDefault(0)->setComment('支付时间'))
             ->addColumn(Column::boolean('pay_status')->setUnsigned()->setDefault(0)->setComment('支付状态：0：待支付；1：已支付；2：退款'))
             ->addColumn(Column::boolean('recharge_status')->setUnsigned()->setDefault(0)->setComment('充值状态：0：待处理；1：已完成'))
             ->addColumn(Column::integer('callback_id')->setUnsigned()->setDefault(0)->setComment('支付回调Id'))
             ->addColumn(Column::string('created_ip', 20)->setDefault('')->setComment('创建时的IP'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addIndex('user_id')
             ->addIndex('order_no')
             ->addIndex('recharge_status')
             ->create();
    }
}
