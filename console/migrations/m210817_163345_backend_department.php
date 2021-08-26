<?php

use yii\db\Migration;

class m210817_163345_backend_department extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%backend_department}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'merchant_id' => "int(11) NULL COMMENT '企业'",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '标题'",
            'cover' => "varchar(255) NULL COMMENT '封面图'",
            'sort' => "int(5) NULL DEFAULT '0' COMMENT '排序'",
            'level' => "tinyint(1) NULL DEFAULT '1' COMMENT '级别'",
            'pid' => "int(50) NULL DEFAULT '0' COMMENT '上级id'",
            'tree' => "text NULL COMMENT '树'",
            'index_block_status' => "tinyint(4) NOT NULL DEFAULT '0' COMMENT '首页块级状态 1=>显示'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台_部门表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%backend_department}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

