<?php
namespace app\modules\blog\controllers\backend;

use yii\web\ForbiddenHttpException;

class PostsController extends \app\modules\core\components\BackendController
{
    public $modelName = '\app\modules\blog\models\Post';
    public $modelSearch = '\app\modules\blog\models\PostSearch';

    public function actionUpdate($id)
    {
        if ($this->_model === null) {
            $model = $this->loadModel($this->modelName, $id);
        } else {
            $model = $this->_model;
        }

        if(!\Yii::$app->user->can('updateOwnPost', ['user_id' => $model->user_id])) {
            throw new ForbiddenHttpException('You are allowed to update only your posts');
        }
        return parent::actionUpdate($id);
    }
}