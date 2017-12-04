<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */


namespace powerkernel\support\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UTCDateTimeBehavior;


if (Yii::$app->getModule('support')->params['db']==='mongodb') {
    /**
     * Class CatActiveRecord
     * @package common\models
     */
    class CatActiveRecord extends \yii\mongodb\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function collectionName()
        {
            return 'support_cats';
        }

        /**
         * @return array
         */
        public function attributes()
        {
            return [
                '_id',
                'title',
                'status',
                'created_at',
                'updated_at',
            ];
        }

        /**
         * get id
         * @return \MongoDB\BSON\ObjectID|string
         */
        public function getId()
        {
            return $this->_id;
        }

        /**
         * @inheritdoc
         */
        public function behaviors()
        {
            return [
                UTCDateTimeBehavior::className(),
            ];
        }

        /**
         * @return int timestamp
         */
        public function getUpdatedAt()
        {
            return $this->updated_at->toDateTime()->format('U');
        }

        /**
         * @return int timestamp
         */
        public function getCreatedAt()
        {
            return $this->created_at->toDateTime()->format('U');
        }        
    }
} else {
    /**
     * Class CatActiveRecord
     * @package common\models
     */
    class CatActiveRecord extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return '{{%support_cat}}';
        }

        /**
         * @inheritdoc
         */
        public function behaviors()
        {
            return [
                TimestampBehavior::className(),
            ];
        }

        /**
         * @return int timestamp
         */
        public function getUpdatedAt()
        {
            return $this->updated_at;
        }

        /**
         * @return int timestamp
         */
        public function getCreatedAt()
        {
            return $this->created_at;
        }        
    }
}

/**
 * Class CatBase
 * @package common\models
 */
class CatBase extends CatActiveRecord {
}