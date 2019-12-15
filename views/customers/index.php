<div class="pull-right" style="clear:both; margin-bottom: 5px;">
    <?= yii\helpers\Html::a('Add', ['customers/add'], ['class' => 'btn btn-success', 'role' => 'button']) ?>
</div>

<?= \yii\widgets\ListView::widget(
    [
        'options' => [
            'class' => 'list-view',
            'id' => 'search_results'
        ],
        'itemView' => 'partials\_customer',
        'dataProvider' => $records
    ]
); ?>