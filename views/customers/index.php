<?php
echo \yii\widgets\ListView::widget(
    [
        'options' => [
            'class' => 'list-view',
            'id' => 'search_results'
        ],
        'itemView' => 'partials\_customer',
        'dataProvider' => $records
    ]
);