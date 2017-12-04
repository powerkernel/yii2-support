<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */

namespace powerkernel\support\console;
use MongoDB\BSON\UTCDateTime;
use yii\db\Query;

/**
 * Class MigrateController
 * @package powerkernel\contact\console
 */
class MigrateController extends \yii\console\Controller
{
    public function actionIndex(){
        echo "Migrating Cat...\n";
        /* logs */
        $rows = (new Query())->select('*')->from('{{%support_cat}}')->all();
        $collection = \Yii::$app->mongodb->getCollection('support_cats');
        foreach ($rows as $row) {
            $collection->insert([
                'title' => $row['title'],
                'status' => (int)$row['status'],
                'created_at' => new UTCDateTime($row['created_at']*1000),
                'updated_at' => new UTCDateTime($row['updated_at']*1000),
            ]);
        }
        echo "Cat migration completed.\n";
    }
}