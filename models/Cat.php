<?php
/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2017 Modern Kernel
 */

namespace modernkernel\support\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%ticket_cat}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Ticket[] $tickets
 */
class Cat extends ActiveRecord
{


    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 20;


    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_ACTIVE => Yii::$app->getModule('support')->t('Active'),
            self::STATUS_INACTIVE => Yii::$app->getModule('support')->t('Inactive'),
        ];
        if (is_array($e))
            foreach ($e as $i)
                unset($option[$i]);
        return $option;
    }

    /**
     * get status text
     * @return string
     */
    public function getStatusText()
    {
        $status = $this->status;
        $list = self::getStatusOption();
        if (!empty($status) && in_array($status, array_keys($list))) {
            return $list[$status];
        }
        return Yii::$app->getModule('support')->t('Unknown');
    }


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
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::$app->getModule('support')->t('ID'),
            'title' => Yii::$app->getModule('support')->t('Title'),
            'status' => Yii::$app->getModule('support')->t('Status'),
            'created_at' => Yii::$app->getModule('support')->t('Created At'),
            'updated_at' => Yii::$app->getModule('support')->t('Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['cat' => 'id']);
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
     * get categories list
     * @return array
     */
    public static function getCatList(){
        $q = (new Query())
            ->select('id, title')
            ->from('{{%support_cat}}')
            ->where(['status'=>Cat::STATUS_ACTIVE])
            ->addOrderBy('title');
        return ArrayHelper::map($q->all(), 'id', 'title');
    }
}
