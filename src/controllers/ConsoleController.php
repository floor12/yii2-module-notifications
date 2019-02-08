<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 18:51
 */

namespace floor12\notifications\controllers;

use floor12\notifications\logic\NotificationQueueProcessor;
use yii\console\Controller;
use yii\helpers\Console;

class ConsoleController extends Controller
{
    public function actionQueue()
    {
        $queueProcessor = new NotificationQueueProcessor();
        $queueProcessor->execute();

        if ($queueProcessor->getErrors())
            foreach ($queueProcessor->getErrors() as $error)
                $this->stdout($error . PHP_EOL, Console::FG_YELLOW);
    }
}