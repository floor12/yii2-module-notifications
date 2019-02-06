<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 12:06
 */

namespace floor12\notifications\models;

use yii2mod\enum\helpers\BaseEnum;

class NotificationType extends BaseEnum
{
    const INFO = 0;
    const SUCCESS = 1;
    const ERROR = 2;

    /**
     * @var string message category
     */
    public static  $messageCategory = 'app.f12.notifications';

    /**
     * @var array list of properties
     */
    public static $list = [
        self::INFO => 'Informaion notification',
        self::SUCCESS => 'Success notification',
        self::ERROR => 'Error notification',
    ];

}