<?php
namespace app\modules\rbac\controllers\commands;

use app\modules\user\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

/**
 * This command grabs all permissions from controllers and add to db
 *
 * @author mlapko <maxlapko@gmail.com>
 * @since 2.0
 */
class CommandController extends Controller
{
    /**
     * This command grabs all permissions from controllers and add to db
     */
    public function actionIndex()
    {
        $app = Yii::getAlias('@app');
        $paths = [$app . '/controllers', $app . '/controllers/backend'];
        
        $config = require($app . '/config/web.php');
        $modules = isset($config['modules']) ? $config['modules'] : [];
        foreach ($modules as $key => $value) {
            $name = is_integer($key) ? $value : $key;
            $paths[] = $app . '/modules/' . $name . '/controllers';
            $paths[] = $app . '/modules/' . $name . '/controllers/backend';
        }
        $permissions = [];
        foreach ($paths as $dir) {
            if (!is_dir($dir)) continue;
            
            foreach (FileHelper::findFiles($dir, ['fileTypes' => ['php']]) as $d) {
                $class = strtr(strtr($d, [$app => 'app', '.php' => '']), ['/' => '\\']);
                if (isset($class::$permissions)) {
                    $permissions = array_merge($permissions, $class::$permissions);
                }
            }
        }
        $permissions = array_unique($permissions);
        $auth = Yii::$app->getAuthManager();
        $oldPermission = $auth->getPermissions();
        $admin = $auth->getRole(User::ROLE_ADMIN);
        foreach ($permissions as $p => $desc) {
            if (is_integer($p)) {
                $p = $desc;
            }
            if (!isset($oldPermission[$p])) {
                $permission = $auth->createPermission($p);
                $permission->description = $desc;
                $auth->add($permission);
                $auth->addChild($admin, $permission);
                echo 'Added permission: ' . $p . PHP_EOL;
            }
        }
    }
}
