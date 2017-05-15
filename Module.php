<?php

namespace modernkernel\support;

use Yii;

/**
 * support module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modernkernel\support\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
        $this->registerMailer();
    }

    /**
     * Config Mailer for the Module
     */
    public function registerMailer()
    {
        Yii::$app->mailer->setViewPath($this->basePath . '/mail');
        Yii::$app->mailer->htmlLayout = '@common/mail/layouts/html';
        Yii::$app->mailer->textLayout = '@common/mail/layouts/text';
    }

    /**
     * Register translation for the Module
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['support'] = [
            'class' => 'common\components\DbMessageSource',
            'on missingTranslation' => function ($event) {
                $event->sender->insertMissingTranslation($event);
            },
        ];
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::$app->getModule('support')->translate($message, $params, $language);
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function translate($message, $params = [], $language = null)
    {
        return Yii::t('support', $message, $params, $language);
    }
}
