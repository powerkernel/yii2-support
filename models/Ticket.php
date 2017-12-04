<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */

namespace powerkernel\support\models;

use common\models\Account;
use common\models\Setting;
use Yii;

/**
 * This is the model class for Ticket.
 *
 * @property integer|\MongoDB\BSON\ObjectID|string $id
 * @property integer|\MongoDB\BSON\ObjectID|string $cat
 * @property string $title
 * @property integer $status
 * @property integer|\MongoDB\BSON\ObjectID|string $created_by
 * @property integer|\MongoDB\BSON\UTCDateTime $created_at
 * @property integer|\MongoDB\BSON\UTCDateTime $updated_at
 *
 * @property Content[] $contents
 * @property Cat $category
 * @property Account $createdBy
 */
class Ticket extends TicketBase
{


    const STATUS_OPEN = 'STATUS_OPEN';
    const STATUS_WAITING = 'STATUS_WAITING';
    const STATUS_CLOSED = 'STATUS_CLOSED';

    public $content;


    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_OPEN => Yii::$app->getModule('support')->t('Open'),
            self::STATUS_WAITING => Yii::$app->getModule('support')->t('Waiting'),
            self::STATUS_CLOSED => Yii::$app->getModule('support')->t('Closed'),
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
     * get status text
     * @return string
     */
    public function getStatusColorText()
    {
        $status = $this->status;
        $list = self::getStatusOption();

        $color = 'default';
        if ($status == self::STATUS_CLOSED) {
            $color = 'danger';
        }
        if ($status == self::STATUS_OPEN) {
            $color = 'primary';
        }
        if ($status == self::STATUS_WAITING) {
            $color = 'warning';
        }

        if (!empty($status) && in_array($status, array_keys($list))) {
            return '<span class="label label-' . $color . '">' . $list[$status] . '</span>';
        }
        return '<span class="label label-' . $color . '">' . Yii::$app->getModule('support')->t('Unknown') . '</span>';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_OPEN],

            [['title', 'cat',], 'required'],
            [['title'], 'string', 'max' => 255],

            [['status'], 'string'],

            [['cat'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::className(), 'targetAttribute' => ['cat' => Yii::$app->getModule('support')->params['db'] === 'mongodb' ? '_id' : 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['created_by' => Yii::$app->params['mongodb']['account'] ? '_id' : 'id']],

            /* custom */
            [['content'], 'required', 'on' => ['create']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::$app->getModule('support')->t('ID'),
            'cat' => Yii::$app->getModule('support')->t('Category'),
            'title' => Yii::$app->getModule('support')->t('Title'),
            'content' => Yii::$app->getModule('support')->t('Content'),
            'status' => Yii::$app->getModule('support')->t('Status'),
            'created_by' => Yii::$app->getModule('support')->t('Created By'),
            'created_at' => Yii::$app->getModule('support')->t('Created At'),
            'updated_at' => Yii::$app->getModule('support')->t('Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getContents()
    {
        if (is_a($this, '\yii\mongodb\ActiveRecord')) {
            return $this->hasMany(Content::className(), ['id_ticket' => '_id']);
        } else {
            return $this->hasMany(Content::className(), ['id_ticket' => 'id']);
        }

    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getCategory()
    {
        if (is_a($this, '\yii\mongodb\ActiveRecord')) {
            return $this->hasOne(Cat::className(), ['_id' => 'cat']);
        } else {
            return $this->hasOne(Cat::className(), ['id' => 'cat']);
        }

    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getCreatedBy()
    {
        if (Yii::$app->params['mongodb']['account']) {
            return $this->hasOne(Account::className(), ['_id' => 'created_by']);
        } else {
            return $this->hasOne(Account::className(), ['id' => 'created_by']);
        }

    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_by = Yii::$app->user->id;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $ticketContent = new Content();
            $ticketContent->id_ticket = $this->id;
            $ticketContent->content = $this->content;
            $ticketContent->created_by = Yii::$app->user->id;
            if ($ticketContent->save()) {
                /* send email */
                $subject = Yii::$app->getModule('support')->t('You\'ve received a ticket');
                Yii::$app->mailer
                    ->compose(
                        [
                            'html' => 'new-ticket-html',
                            'text' => 'new-ticket-text'
                        ],
                        ['title' => $subject, 'model' => $this]
                    )
                    ->setFrom([Setting::getValue('outgoingMail') => Yii::$app->name])
                    ->setTo(Setting::getValue('adminMail'))
                    ->setSubject($subject)
                    ->send();
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * get ticket url
     * @param bool $absolute
     */
    public function getUrl($absolute = false)
    {
        $act = 'createUrl';
        if ($absolute) {
            $act = 'createAbsoluteUrl';
        }
        return Yii::$app->urlManagerFrontend->$act(['support/ticket/view', 'id' => (string)$this->id]);
    }

    /**
     * system closes ticket
     */
    public function close()
    {
        if ($this->status != Ticket::STATUS_CLOSED) {
            $post = new Content();
            $post->id_ticket = $this->id;
            $post->created_by = null;
            $post->content = Yii::$app->getModule('support')->t('Ticket was closed automatically due to inactivity.');
            if ($post->save()) {
                $this->status = Ticket::STATUS_CLOSED;
                $this->save();
            }
        }
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function beforeDelete()
    {
        foreach ($this->contents as $content) {
            $content->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}
