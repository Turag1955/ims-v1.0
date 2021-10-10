<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{
    protected $order = array('id' => 'desc');
    protected  $column_order = [];

    protected  $orderValue;
    protected  $dirValue;
    protected $length;
    protected $start;


    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }

    public function setdirValue($dirValue)
    {
        $this->dirValue = $dirValue;
    }
    public function setLengthValue($length)
    {
        $this->length = $length;
    }
    public function setStartValue($start)
    {
        $this->start = $start;
    }
}
