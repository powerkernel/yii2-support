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


if (Yii::$app->getModule('support')->params['db'] === 'mongodb') {
    /**
     * Class ContentActiveRecord
     * @package common\models
     */
    class ContentActiveRecord extends \yii\mongodb\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function collectionName()
        {
            return 'support_ticket_content';
        }

        /**
         * @return array
         */
        public function attributes()
        {
            return [
                '_id',
                'id_ticket',
                'content',
                'created_by',
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
     * Class ContentActiveRecord
     * @package common\models
     */
    class ContentActiveRecord extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return '{{%support_ticket_content}}';
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
 * Class ContentBase
 * @package common\models
 */
class ContentBase extends ContentActiveRecord
{
}