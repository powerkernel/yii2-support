<?php

/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */


use common\Core;
use common\widgets\SideMenu;

$menu=[
    'title'=>Yii::$app->getModule('support')->t('Ticket System'),
    'icon'=> 'support',
    'items'=>[
        ['icon' => 'ticket', 'label' => Yii::$app->getModule('support')->t('My Tickets'), 'url' => ['/support/ticket/manage'], 'active' => Core::checkMCA('support', 'ticket', ['manage', 'view'])],
        ['icon' => 'question-circle', 'label' => Yii::$app->getModule('support')->t('Open Ticket'), 'url' => ['/support/ticket/create'], 'active' => Core::checkMCA('support', 'ticket', 'create')],
    ],
];
$menu['active']=SideMenu::isActive($menu['items']);
return [$menu];