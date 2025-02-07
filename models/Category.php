<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

namespace copoka\support\models;

use copoka\support\Module;
use copoka\support\traits\ModuleTrait;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer|\MongoDB\BSON\ObjectID|string $id
 * @property string $title
 * @property integer $status
 * @property integer|\MongoDB\BSON\UTCDateTime $created_at
 * @property integer|\MongoDB\BSON\UTCDateTime $updated_at
 *
 * @property Ticket[] $tickets
 */
class Category extends CategoryBase
{
    use ModuleTrait;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 20;

    /**
     * get categories list
     * @return array
     */
    public static function getCatList()
    {
        $cats = self::find()->where(['status' => self::STATUS_ACTIVE])->all();
        return ArrayHelper::map($cats, function ($model) {
            return is_a($model, '\yii\mongodb\ActiveRecord') ? (string)$model->_id : $model->id;
        }, 'title');
    }

    /**
     * color status text
     * @return mixed|string
     */
    public function getStatusColorText()
    {
        $status = $this->status;
        if ($status == self::STATUS_ACTIVE) {
            return '<span class="label label-success">' . $this->statusText . '</span>';
        }
        if ($status == self::STATUS_INACTIVE) {
            return '<span class="label label-default">' . $this->statusText . '</span>';
        }
        return $this->statusText;
    }

    /**
     * get status text
     * @return string
     */
    public function getStatusText()
    {
        $status = $this->status;
        $list = self::getStatusOption();
        if (!is_null($status) && in_array($status, array_keys($list))) {
            return $list[$status];
        }
        return \copoka\support\Module::t('support', 'Unknown');
    }

    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_ACTIVE => Module::t('support', 'Active'),
            self::STATUS_INACTIVE => Module::t('support', 'Inactive'),
        ];
        if (is_array($e)) {
            foreach ($e as $i) {
                unset($option[$i]);
            }
        }
        return $option;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('support', 'ID'),
            'title' => Module::t('support', 'Title'),
            'status' => Module::t('support', 'Status'),
            'created_at' => Module::t('support', 'Created At'),
            'updated_at' => Module::t('support', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->status = (int)$this->status;
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
