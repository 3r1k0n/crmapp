<?php
use app\models\customer\CustomerRecord;
use app\models\customer\PhoneRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * Add Custimer UI.
 *
 * @var View $this
 * @var CustomerRecord $customer
 * @var PhoneRecord $phone
 */

 $form = ActiveForm::begin([
    'id' => 'add-customer-form'
]);

echo $form->errorSummary([$customer, $phone]);
echo $form->field($customer, 'id', ['labelOptions'=>['class' => 'hidden']])->hiddenInput();
echo $form->field($customer, 'name');
echo $form->field($customer, 'birth_date');
echo $form->field($customer , 'sales_status')->dropDownList(["Warm"=>"Warm", "Cold"=>"Cold", "Closed"=>"Closed"]);
echo $form->field($customer, 'notes');
echo $form->field($phone, 'id', ['labelOptions'=>['class' => 'hidden']])->hiddenInput();
echo $form->field($phone, 'number');
?>
<div>
    <div class='inline-block'>
        <?php
            if($customer->attachment_path){
                echo Html::img("/".$customer->attachment_path, ['alt'=>$customer->name, 'class'=>'thumbnail']);
            } 
        ?>
    </div>
    <div class='inline-block'>
        <?= $form->field($customer, 'attachment')->label('Photo')->fileInput() ?>
    </div>
</div>

<?php
echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);
ActiveForm::end();
?>