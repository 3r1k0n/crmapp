<?php
namespace app\models\customer;

class Customer
{
    /** @var  int */
    public $id;

    /** @var  string */
    public $name;

    /** @var  \DateTime */
    public $birth_date;

    /** @var string */
    public $notes = '';

    /** @var PhoneRecord[] */
    public $phones = [];

    /** @var  string */
    public $sales_status;

    /** @var  string */
    public $attachment_path;

    public function __construct($name, $birth_date)
    {
        $this->name = $name;
        $this->birth_date = $birth_date;
    }
}