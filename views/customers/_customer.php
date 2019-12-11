<?php

use yii\helpers\Html;

echo \yii\widgets\DetailView::widget(
    [
        'model' => $model,
        'attributes' => [
            ['attribute' => 'name'],
            [
                'label'=>'Photo',
                'format'=>'raw',
                'value' => function($model){
                    if($model->attachment_path){
                     return Html::a(Html::img($model->attachment_path, ['style'=>'max-width:100px;max-height:100px;', 'alt'=>$model->name]), [ $model->attachment_path ]);
                    }
                }
           ],
            ['attribute' => 'birth_date', 'value' => $model->birth_date->format('Y-m-d')],
            'notes:text',
            ['attribute' => 'sales_status'],
            ['label' => 'Phone Number', 'attribute' => 'phones.0.number']
        ]
    ]
);