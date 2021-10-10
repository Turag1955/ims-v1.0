<?php

namespace Modules\Supplier\Entities;

use Modules\Base\Entities\BaseModel;



class Supplier extends BaseModel
{

    protected $name;
    protected $email;
    protected $phone;

    protected $fillable = ['name', 'company_name', 'vat_number', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country', 'status', 'created_by', 'updated_by'];

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    protected function get_data_table_query()
    {
        if (permission('supplier-bulk-delete')) {
            $this->column_order = [null, 'id', 'name', 'email', 'phone', 'company_name', 'vat_number', 'city', 'postal_code', 'country', 'address', 'status', null];
        } else {
            $this->column_order = ['id', 'name', 'email', 'phone', 'company_name', 'vat_number', 'city', 'postal_code', 'country', 'address', 'status', null];
        }
        $query = self::toBase();
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }
        if (!empty($this->phone)) {
            $query->where('phone', 'like', '%' . $this->phone . '%');
        }
        if (!empty($this->email)) {
            $query->where('email', 'like', '%' . $this->email . '%');
        }
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else {
            $query->orderBy('id', 'desc');
        }
        return $query;
    }

    public function get_dataTable()
    {
        $query = $this->get_data_table_query();
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function totalField()
    {
        return self::toBase()->get()->count();
    }

    public function totalFilter()
    {
        $query = $this->get_data_table_query();

        return   $query->get()->count();
    }
}
