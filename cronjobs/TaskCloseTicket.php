<?php
/**
 * @var \omnilight\scheduling\Schedule $schedule
 */

use common\Core;
use modernkernel\support\models\Ticket;


$local = Core::isLocalhost();
$time = $local ? '* * * * *' : '0 20 * * *';


$schedule->call(function (\yii\console\Application $app) {
    $period = 7 * 86400; // 7 days
    $point = time() - $period;

    if(Yii::$app->getModule('support')->params['db']==='mongodb'){
        $tickets = Ticket::find()
            ->where([
                'status'=>Ticket::STATUS_WAITING,
                'updated_at'=>['$lt'=>new \MongoDB\BSON\UTCDateTime($point*1000)]
            ])
            ->all();
    }
    else {
        $tickets = Ticket::find()
            ->where('status=:status AND updated_at<:point', [':point' => $point, ':status' => Ticket::STATUS_WAITING])
            ->all();
    }


    if ($tickets) {
        $ids = [];
        foreach ($tickets as $ticket) {
            $ids[] = $ticket->id;
            $ticket->close();
        }

        $output = implode(', ', $ids);

    }


    /* Result */
    if (!empty($output)) {
        $log = new \common\models\TaskLog();
        $log->task = basename(__FILE__, '.php');
        $log->result = $output;
        $log->save();
    }

    /* delete old logs never bad */
    $period = 30 * 24 * 60 * 60; // 30 days
    $point = time() - $period;
    if(Yii::$app->params['mongodb']['taskLog']){
        \common\models\TaskLog::deleteAll([
            'task'=>basename(__FILE__, '.php'),
            'created_at'=>['$lte', new \MongoDB\BSON\UTCDateTime($point*1000)]
        ]);
    }
    else {
        \common\models\TaskLog::deleteAll('task=:task AND created_at<=:point', [
            ':task' => basename(__FILE__, '.php'),
            ':point' => $point
        ]);
    }
    unset($app);
})->cron($time);