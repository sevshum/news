<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\UserPostOwnerRule;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InstallController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $config = require(Yii::getAlias('@app/config') . '/web.php');
        $modules = isset($config['modules']) ? $config['modules'] : [];
        foreach ($modules as $key => $value) {
            $name = is_integer($key) ? $value : $key;
            $alias = '@app/modules/' . $name . '/migrations';
            if (is_dir(Yii::getAlias($alias, false))) {
                $this->run('migrate/up', ['migrationPath' => $alias, 'interactive' => 0]);
            }
        }
        $this->run('migrate/up', ['interactive' => 0]);
        $this->_rbac();
    }

    public function _rbac()
    {
        $authManager = \Yii::$app->authManager;

        // add "createPost" permission
        $createPost = $authManager->createPermission('createPost');
        $createPost->description = 'Create a post';
        $authManager->add($createPost);

        $adminPerm = $authManager->createPermission('/rbac/permissions/admin');
        $adminPerm->description = 'Administer permissions';
        $authManager->add($adminPerm);

        $assignPerm = $authManager->createPermission('/rbac/permissions/assign');
        $assignPerm->description = 'Assign permissions';
        $authManager->add($assignPerm);

        // add "updatePost" permission
        $updatePost = $authManager->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $authManager->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $manager = $authManager->createRole('manager');
        $authManager->add($manager);
        $authManager->addChild($manager, $createPost);

        $rule = new UserPostOwnerRule();
        $authManager->add($rule);

// add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $authManager->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $authManager->add($updateOwnPost);

// "updateOwnPost" will be used from "updatePost"
        $authManager->addChild($updateOwnPost, $updatePost);

// allow "author" to update their own posts
        $authManager->addChild($manager, $updateOwnPost);
        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $authManager->createRole('admin');
        $authManager->add($admin);
        $authManager->addChild($admin, $updatePost);
        $authManager->addChild($admin, $manager);
        $authManager->addChild($admin, $adminPerm);
        $authManager->addChild($admin, $assignPerm);

        $authManager->assign($admin, 1);
        $authManager->assign($manager, 2);
    }
}

