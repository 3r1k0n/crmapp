<?php

namespace app\models\customer;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class CustomerRecord extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $attachment;

    public static function tableName()
    {
        return 'customer';
    }

    public function upload()
    {
        if ($this->validate() && $this->attachment) {
            $path = 'uploads/' . $this->attachment->baseName . '.' . $this->attachment->extension;
            $this->attachment->saveAs($path);
            $this->attachment_path = $path;
            return true;
        } else {
            return false;
        }
    }

    public function rules()
    {
        return [
            ['id', 'number'],
            ['name', 'required'],
            ['name', 'string', 'max' => 256],
            ['birth_date', 'date', 'format' => 'php:Y-m-d'],
            ['notes', 'safe'],
            ['sales_status', 'in', 'range' => ['Closed', 'Warm', 'Cold']],
            [['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ['attachment_path', 'string', 'max' => 256],
        ];
    }
}