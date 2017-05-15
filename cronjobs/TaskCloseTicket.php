<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

use common\Core;
use modernkernel\ticket\models\Ticket;


$local = Core::isLocalhost();
$time = $local ? '* * * * *' : '0 8 * * *';


$schedule->call(function (\yii\console\Application $app) {
    $output = '';
    $day=7;
    $time=time()-$day*86400;

    $tickets = Ticket::find()
        ->where(['status'=>Ticket::STATUS_WAITING])
        ->andWhere('updated_at<:time', [':time'=>$time])
        ->all();

    if ($tickets) {
        $ids = [];
        foreach ($tickets as $ticket) {
            $ids[] = $ticket->id;
            $ticket->close();
        }

        $output = implode(', ', $ids);

    }


    /* Result */
    if (empty($output)) {
        $output = $app->getModule('ticket')->t('Nothing to do');
    }
    echo $app->getModule('ticket')->t(basename(__FILE__, '.php') . ': ' . $output . "\n\n");
})->cron($time);