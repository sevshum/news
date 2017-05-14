<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\modules\blog\models\Post;
use app\modules\notifications\models\NotificationSetting;
use app\modules\user\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Url;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class NotificationsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $lastPost = Post::getLast();
        if ($lastPost) {
            foreach (User::find()->where(['status' => User::STATUS_ACTIVE])->each(100) as $user) {
                if ((int) $user->getNotificationSettings()->select('value')->where(['setting_id' => NotificationSetting::TYPE_EMAIL])->scalar() === NotificationSetting::VALUE_SELECTED) {
                    if (($userLastPostId = (int) $user->getNotificationLastNews()->select('post_id')->scalar()) < $lastPost->id) {
                        Yii::$app->getModule('mail')
                            ->createMessage()
                            ->setTemplate('new_post', [
                                'count' => Post::find()->where(['>', 'id', $userLastPostId])->count(),
                                'link' => $lastPost->getUrl(true)
                            ])
                            ->setTo($user->email)
                            ->send();
                    }
                }
            }
        }


    }
}

