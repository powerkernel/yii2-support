<?php

use yii\db\Migration;

/**
 * Class m170511_080718_init
 */
class m170511_080718_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%support_cat}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%support_ticket_head}}', [
            'id' => $this->primaryKey(),
            'cat'=> $this->integer()->null()->defaultValue(null),
            'title' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_support_ticket_head_created_by-core_account_id', '{{%support_ticket_head}}', 'created_by', '{{%core_account}}', 'id');
        $this->addForeignKey('fk_support_ticket_head_cat-support_cat_id', '{{%support_ticket_head}}', 'cat', '{{%support_cat}}', 'id');

        $this->createTable('{{%support_ticket_content}}', [
            'id' => $this->primaryKey(),
            'id_ticket' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_by' => $this->integer()->null()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_support_ticket_content_id-support_ticket_head_id', '{{%support_ticket_content}}', 'id_ticket', '{{%support_ticket_head}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_support_ticket_content_created_by-core_account_id', '{{%support_ticket_content}}', 'created_by', '{{%core_account}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_support_ticket_content_created_by-core_account_id', '{{%support_ticket_content}}');
        $this->dropForeignKey('fk_support_ticket_content_id-support_ticket_head_id', '{{%support_ticket_content}}');
        $this->dropTable('{{%support_ticket_content}}');

        $this->dropForeignKey('fk_support_ticket_head_cat-support_cat_id', '{{%support_ticket_head}}');
        $this->dropForeignKey('fk_support_ticket_head_created_by-core_account_id', '{{%support_ticket_head}}');
        $this->dropTable('{{%support_ticket_head}}');

        $this->dropTable('{{%support_cat}}');
    }

}
