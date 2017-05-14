<?php
namespace app\modules\rbac\assets;

use Yii;
use yii\web\AssetBundle;

/**
 *
 * @author mlapko
 */
class PermissionAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/js';
        $this->js = ['permissions.js'];
        $this->depends = [
            'yii\web\JqueryAsset'
        ];
        
        Yii::$app->getView()->registerJs('
            window.I18NS = {
                success: "' . Yii::t('app', 'Successfully updated.') . '",
                error: "' . Yii::t('app', 'System error.') . '",
            };
        ');
        
        parent::init();
    }
}
