<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 2019-02-06
 * Time: 18:53
 */

namespace floor12\notifications\models;


use floor12\editmodal\FilterModelInterface;
use floor12\notifications\interfaces\NotificationQueryInterface;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class NotificationAdminFilter extends Model implements FilterModelInterface
{
    /**
     * @var string
     */
    public $filter;
    /**
     * @var int
     */
    public $unreaded = 0;
    /**
     * @var NotificationQueryInterface
     */
    protected $query;
    /**
     * @var string
     */
    protected $notificationClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!Yii::$app->getModule('notifications'))
            throw new InvalidConfigException('Notification module is not registred in this application.');

        $this->notificationClass = Yii::$app->getModule('notifications')->notificationClass;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['filter', 'string'],
            ['unreaded', 'integer'],
        ];
    }

    /**
     * @return ActiveDataProvider
     * @throws BadRequestHttpException
     */
    public function dataProvider()
    {
        if (!$this->validate())
            throw new BadRequestHttpException('Filter model  validating error');
        /**
         * @var NotificationQueryInterface
         */
        $this->query = $this->notificationClass::find()
            ->andFilterWhere(['LIKE', 'body', $this->filter]);

        if ($this->unreaded)
            $this->query->unreaded();


        return new ActiveDataProvider([
            'query' => $this->query,
            'sort' => ['defaultOrder' => ['created' => SORT_DESC]]
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'unreaded' => Yii::t('app.f12.notifications', 'show only unreaded notifications')
        ];
    }
}