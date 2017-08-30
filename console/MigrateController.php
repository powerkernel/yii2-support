<?php
/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2017 Modern Kernel
 */

namespace modernkernel\support\console;
use MongoDB\BSON\UTCDateTime;
use yii\db\Query;

/**
 * Class MigrateController
 * @package modernkernel\contact\console
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
        /* settings */

        echo "Cat migration completed.\n";
    }
}