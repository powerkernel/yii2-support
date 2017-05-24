<?php

/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2017 Modern Kernel
 */


use common\Core;
use common\widgets\SideMenu;


$menu=[
    'title'=>Yii::$app->getModule('support')->t('Ticket System'),
    'icon'=> 'support',
    'items'=>[
        ['icon' => 'ticket', 'label' => Yii::$app->getModule('support')->t('Tickets'), 'url' => ['/support/ticket/index'], 'active' => Core::checkMCA('support', 'ticket', '*')],
        ['icon' => 'cubes', 'label' => Yii::$app->getModule('support')->t('Categories'), 'url' => ['/support/cat/index'], 'active' => Core::checkMCA('support', 'cat', '*')],
    ],
];
$menu['active']=SideMenu::isActive($menu['items']);
return [$menu];