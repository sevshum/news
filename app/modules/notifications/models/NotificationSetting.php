<?php

namespace app\modules\notifications\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "notification_settings".
 *
 * @property int $id
 * @property string $user_id
 * @property string $setting_id
 * @property int $value
 * @property string $created_at
 * @property string $updated_at
 */
class NotificationSetting extends \yii\db\ActiveRecord
{
    const TYPE_EMAIL = 1;
    const TYPE_BROWSER = 2;

    const VALUE_NOT_SELECTED = 0;
    const VALUE_SELECTED = 1;

    public static function types($type = null)
    {
        static $types = [
            self::TYPE_EMAIL  => 'Email',
            self::TYPE_BROWSER  => 'Browser'
        ];
        return $type === null ? $types : $types[$type];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_settings';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => function() {
                    return date('Y-m-d H:i:s');
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'setting_id', 'value'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'setting_id' => Yii::t('app', 'Setting ID'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param int $userId
     * @param int $settingId
     * @param bool $value
     * @return bool
     */
    public static function set($userId, $settingId, $value)
    {
        if (!$model = self::findOne(['user_id' => $userId, 'setting_id' => $settingId])) {
            $model = new self(['user_id' => $userId, 'setting_id' => $settingId]);
        }
        $model->value = $value;
        return $model->save();
    }

    /**
     * @param int $userId
     * @param int $settingId
     * @return boolean
     */
    public static function get($userId, $settingId)
    {
        if (!$model = self::findOne(['user_id' => $userId, 'setting_id' => $settingId])) {
            $model = new self(['user_id' => $userId, 'setting_id' => $settingId]);
            $model->value = self::VALUE_NOT_SELECTED;
            $model->save();
        }
        return $model->value;
    }
} 