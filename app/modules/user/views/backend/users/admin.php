<?php

use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel UserSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
//$this->params['breadcrumbs'][] = $this->title;
$this->params['rightTitle'] = Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success pull-right']);
$user = Yii::$app->getUser();

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table'],
    'options' => ['class' => 'table-responsive grid-view'],
    'layout' => "{items}\n<div class=\"text-center\">{pager}</div>",
    'pager' => ['options' => ['class' => 'pagination pagination-sm']],
    'rowOptions' => function($model) {
        $class = '';
        if ($model->status === User::STATUS_BLOCKED) {
            $class = 'warning';
        } elseif ($model->status === User::STATUS_DELETED) {
            $class = 'danger';
        }
        return ['class' => $class];
    },
    'columns' => [
        'id',
        'username',
        'email:email',
        [
            'attribute' => 'created_at',
            'value' => 'created_at',
            'filter' => \yii\jui\DatePicker::widget([
                'model'=>$searchModel,
                'attribute'=>'created_at',
                'language' => 'en',
                'dateFormat' => 'dd-MM-yyyy',
            ]),
            'format' => 'html',
        ],
        [
            'attribute' => 'last_login_at',
            'value' => 'last_login_at',
            'filter' => \yii\jui\DatePicker::widget([
                'model'=>$searchModel,
                'attribute'=>'last_login_at',
                'language' => 'en',
                'dateFormat' => 'dd-MM-yyyy',
            ]),
            'format' => 'html',
        ],
        [
            'attribute' => 'status',
            'value' => function($model) {
                return User::statuses($model->status);
            },
            'filter' => User::statuses()
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'options' => ['style' => 'width:50px']
        ],
    ],
]); ?>