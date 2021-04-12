<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Regions extends Migrator
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
        if ($this->hasTable('regions')) return;
        $this->table('regions', ['engine'=>'Innodb'])
             ->setComment('地址表')
             ->setCollation(env('DATABASE.CHARSET_COLLATION'))
             ->setId('region_id')
             ->setPrimaryKey('region_id')
             ->addColumn(Column::integer('parent_id')->setUnsigned()->setDefault(0)->setComment('父级Id'))
             ->addColumn('shortname', 'string', ['limit' => 200, 'default' => '', 'comment' => '简称'])
             ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '名称'])
             ->addColumn('merger_name', 'string', ['limit' => 200, 'default' => '', 'comment' => '全称'])
             ->addColumn(Column::tinyInteger('level')->setUnsigned()->setDefault(0)->setComment('层级：1.省；2.市; 3.区县'))
             ->addColumn('pinyin', 'string', ['limit' => 200, 'default' => '', 'comment' => '拼音'])
             ->addColumn('code', 'string', ['limit' => 200, 'default' => '', 'comment' => '长途区号'])
             ->addColumn('zip_code', 'string', ['limit' => 200, 'default' => '', 'comment' => '邮编'])
             ->addColumn('first', 'string', ['limit' => 200, 'default' => '', 'comment' => '首字母'])
             ->addColumn('lng', 'string', ['limit' => 200, 'default' => '', 'comment' => '经度'])
             ->addColumn('lat', 'string', ['limit' => 200, 'default' => '', 'comment' => '纬度'])
             ->addColumn(Column::boolean('is_delete')->setUnsigned()->setDefault(0)->setComment('是否删除：0：否；1：是'))
             ->addColumn(Column::integer('created_time')->setUnsigned()->setDefault(0)->setComment('创建时间'))
             ->addColumn(Column::integer('updated_time')->setUnsigned()->setDefault(0)->setComment('更新时间'))
             ->addIndex('parent_id')
             ->addIndex('is_delete')
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
        $this->dropTable('regions');
    }
}
