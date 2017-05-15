<?php

/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2017 Modern Kernel
 */


use common\Core;

return [
    ['label' => Yii::$app->getModule('support')->t('Ticket System')],
    ['icon' => 'ticket', 'label' => Yii::$app->getModule('support')->t('My Tickets'), 'url' => ['/support/ticket/manage'], 'active' => Core::checkMCA('support', 'ticket', 'manage')],
    ['icon' => 'question-circle', 'label' => Yii::$app->getModule('support')->t('Open Ticket'), 'url' => ['/support/ticket/create'], 'active' => Core::checkMCA('support', 'ticket', 'create')],
];