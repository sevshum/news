<?php

namespace app\rbac;

use app\modules\user\models\User;
use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $group = \Yii::$app->user->identity->role;
            if ($item->name === 'admin') {
                return $group === User::ROLE_ADMIN;
            } elseif ($item->name === 'user') {
                return $group === User::ROLE_ADMIN || $group === User::ROLE_USER;
            }
        }
        return false;
    }
}