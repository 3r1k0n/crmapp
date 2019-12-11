<?php
use yii\helpers\Url;
use yii\helpers\Html;

if(!$target_id){
    return;
}?>

<div class="pull-right" style="margin-bottom: 5px">
    <?= Html::a('Update', ['customers/update', 'id' => $target_id], ['class' => 'btn btn-warning', 'role' => 'button']) ?>
    <?= Html::a('Delete', ['customers/delete', 'id' => $target_id], ['class' => 'btn btn-danger', 'role' => 'button', 'onclick'=>"return confirm('Are you sure?')"]) ?>
</div>