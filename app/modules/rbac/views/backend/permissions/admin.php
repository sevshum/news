<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions \yii\rbac\Permission[] */
$this->title = Yii::t('app', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
$canEdit = Yii::$app->getUser()->can('/rbac/permissions/assign');
if ($canEdit) {
    $this->registerAssetBundle('\app\modules\rbac\assets\PermissionAsset');
}
?>

<table class="table table-bordered" id="permissions" data-url="<?= \yii\helpers\Url::toRoute(['/rbac/permissions/assign'])?>">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <?php foreach ($roles as $role) : ?>
            <th><?= h($role->description) ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permissions as $p) : ?>
        <tr>
            <td><?= h($p->name) ?></td>
            <?php foreach ($roles as $role) : ?>
            <?php $checked = isset($connects[$role->name][$p->name]) ?>
            <th>
                <?= $canEdit ? 
                    Html::checkbox('role', $checked, ['class' => 'assign', 'data-role' => $role->name, 'data-permission' => $p->name]) : 
                    ($checked ? 'Yes' : 'No') 
                ?>
            </th>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>