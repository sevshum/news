<?php

namespace app\modules\rbac\controllers\backend;

use app\modules\core\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class PermissionsController extends BaseController
{
    public static $permissions = [
        '/rbac/permissions/admin',
        '/rbac/permissions/assign'
    ];
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'matchCallback' => [$this, 'matchCallback']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['assign'],
                ],
            ],
        ];
    }
    
    public function actionAdmin()
    {
        $auth = Yii::$app->getAuthManager();
        $roles = $auth->getRoles();
        
        $connects = [];
        foreach ($roles as $role) {
            $connects[$role->name] = $auth->getPermissionsByRole($role->name);
        }
        return $this->render('admin', [
            'permissions' => $auth->getPermissions(),
            'roles' => $auth->getRoles(),
            'connects' => $connects
        ]);
    }
    
    public function actionAssign()
    {
        $request = Yii::$app->getRequest();
        $auth = Yii::$app->getAuthManager();
        $role = $auth->getRole($request->post('role'));
        $permission = $auth->getPermission($request->post('permission'));
        $assign = $request->post('assign', false);
        if (!$role || !$permission) {
            return $this->renderJson(['success' => false]);
        }
        $success = true;
        try {
            if ($assign) {
                $auth->addChild($role, $permission);
            } else {
                $auth->removeChild($role, $permission);
            }
        } catch (\Exception $ex) {
            $success = false;
        }
        return $this->renderJson(['success' => $success]);
    }
}