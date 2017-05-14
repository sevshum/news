<?= \nkovacs\pagesizer\ListView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'post-list',
    'itemView' => '_view',
    'pageSizer' => ['availableSizes' => [10 => '10 per page', 25 => '25 per page', 50 => '50 per page']],
    'layout' => "{summary}\n{pagesizer}\n{items}\n{pager}",
]); ?>
