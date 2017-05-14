<?php
namespace app\components;

use app\modules\user\models\User;
use yii\rbac\Rule;
use yii\rbac\Item;

class UserPostOwnerRule extends Rule
{
    public $name = 'isPostOwner';

    /**
     * @param string|integer $user   the user ID.
     * @param Item           $item   the role or permission that this rule is associated with
     * @param array          $params parameters passed to ManagerInterface::checkAccess().
     *
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (\Yii::$app->user->identity->role == User::ROLE_ADMIN) {
            return true;
        }
        return isset($params['user_id']) ? \Yii::$app->user->id == $params['user_id'] : false;
    }
}
//if (!\Yii::$app->user->can('updateOwnProfile', ['profileId' => \Yii::$app->user->id])) {
//    throw new ForbiddenHttpException('Access denied');
//}