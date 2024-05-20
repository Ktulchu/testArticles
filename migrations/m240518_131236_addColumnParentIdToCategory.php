<?php

use yii\db\Migration;

/**
 * Class m240518_131236_addColumnParentIdToCategory
 */
class m240518_131236_addColumnParentIdToCategory extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'parentId', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'parentId');
    }
}
