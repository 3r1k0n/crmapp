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
echo $form->field($customer, 'name');
echo $form->field($customer, 'birth_date');
echo $form->field($customer , 'sales_status')->dropDownList(["Warm"=>"Warm", "Cold"=>"Cold", "Closed"=>"Closed"]);
echo $form->field($customer, 'notes');
echo $form->field($phone, 'number');
echo $form->field($customer, 'attachment')->fileInput();

echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);
ActiveForm::end();