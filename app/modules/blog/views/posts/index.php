<?php
$this->title = Yii::t('app', 'News');
?>
<h1><?= h($this->title) ?></h1>
<?= $this->render('_list', compact('dataProvider')); ?>