<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\customer\CustomerRecord;
use app\models\customer\Phone;
use app\models\customer\PhoneRecord;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;

class CustomersController extends Controller
{
    public function actionIndex()
    {
        $records = $this->findRecordsByQuery();
        return $this->render('index', compact('records'));
    }

    private function findRecordsByQuery()
    {
        $number = \Yii::$app->request->get('phone_number');
        $records = $number ? $this->getRecordsByPhoneNumber($number) : $this->getAllRecords();
        $dataProvider = $this->wrapIntoDataProvider($records);
        return $dataProvider;
    }

    private function getAllRecords(){
        $customer_records = CustomerRecord::find()->all();
        $phone_records = PhoneRecord::find()->all();

        $result = [];
        foreach($customer_records as $customer_record) {
            $related_phone_record = NULL;
            foreach ($phone_records as $phone_record) {
                if ($customer_record->id == $phone_record->customer_id) {
                    $related_phone_record = $phone_record;
                    break;
                }
            }
            array_push($result, $this->makeCustomer($customer_record, $related_phone_record));
        }

        return $result;
    }

    private function getRecordsByPhoneNumber($number)
    {
        $phone_records = PhoneRecord::findAll(['number' => $number]);
        if (!$phone_records) {
            return [];
        }

        $customer_ids = array_column($phone_records, 'customer_id');
        $customer_records = CustomerRecord::findAll($customer_ids);
        if (!$customer_records) {
            return [];
        }

        $result = [];
        foreach ($phone_records as $phone_record) {
            foreach($customer_records as $customer_record) {
                if ($customer_record->id == $phone_record->customer_id) {
                    array_push($result, $this->makeCustomer($customer_record, $phone_record));
                    break;
                }
            }
        }

        return $result;
    }

    private function makeCustomer(CustomerRecord $customer_record, ?PhoneRecord $phone_record) {
        $name = $customer_record->name;
        $birth_date = new \DateTime($customer_record->birth_date);

        $customer = new Customer($name, $birth_date);
        $customer->id = $customer_record->id;
        $customer->notes = $customer_record->notes;
        if($phone_record){
            $customer->phones[] = new Phone($phone_record->number);
        }else{
            $customer->phones[] = [];
        }
        $customer->sales_status = $customer_record->sales_status;
        $customer->attachment_path = $customer_record->attachment_path;

        return $customer;
    }

    private function wrapIntoDataProvider($data)
    {
        return new ArrayDataProvider(
            [
                'allModels' => $data,
                'pagination' => false
            ]
        );
    }

    public function actionAdd()
    {
        $customer = new CustomerRecord();
        $phone = new PhoneRecord();

        if ($this->load($customer, $phone, $_POST)) {
            $customer->attachment = UploadedFile::getInstance($customer, 'attachment');
            $customer->upload();

            $this->store($this->makeCustomer($customer, $phone));

            return $this->redirect('/customers');
        }

        return $this->render('add', compact('customer', 'phone'));
    }

    private function load(CustomerRecord $customer, PhoneRecord $phone, array $post)
    {
        return $customer->load($post)
        and $phone->load($post)
        and $customer->validate()
        and $phone->validate(['number']);
    }

    private function store(Customer $customer)
    {
        $customer_record = new CustomerRecord();
        $customer_record->name = $customer->name;
        $customer_record->birth_date = $customer->birth_date->format('Y-m-d');
        $customer_record->notes = $customer->notes;
        $customer_record->sales_status = $customer->sales_status;
        $customer_record->attachment_path = $customer->attachment_path;

        $customer_record->save();

        foreach ($customer->phones as $phone) {
            $phone_record = new PhoneRecord();
            $phone_record->number = $phone->number;
            $phone_record->customer_id = $customer_record->id;
            $phone_record->save();
        }
    }

    public function actionQuery()
    {
        return $this->render('query');
    }

    public function actionDelete($id)
    {
        $related_phone_record = PhoneRecord::findOne(['customer_id' => $id]);
        if($related_phone_record){
            $related_phone_record->delete();
        }

        CustomerRecord::findOne($id)->delete();

        $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $customer = new CustomerRecord();
        $phone = new PhoneRecord();

        

        if ($this->load($customer, $phone, $_POST) && $customer->id) {
            $customer_record = CustomerRecord::findOne($customer->id);
            $customer_record->name = $customer->name;
            $customer_record->birth_date = $customer->birth_date;
            $customer_record->sales_status = $customer->sales_status;

            $attached_file = UploadedFile::getInstance($customer, 'attachment');
            if($attached_file){
                $customer_record->attachment = $attached_file;
                $customer_record->upload();
            }
            $customer_record->save(false);

            $phone_record = $phone->id? PhoneRecord::findOne($phone->id) : new PhoneRecord();
            $phone_record->customer_id = $customer->id;
            $phone_record->number = $phone->number;
            $phone_record->save();

            $this->redirect(['index']);
        }

        $customer = CustomerRecord::findOne($id);
        $phone = PhoneRecord::findOne(['customer_id' => $id]) ?? new PhoneRecord();

        return $this->render('add', compact('customer', 'phone'));

        return $id;
    }
}