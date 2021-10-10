<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositories extends BaseRepositories
{
    protected $role_id;
    protected $name;
    protected $mobile_no;
    protected $email;
    protected $status;
    protected $gender;
    protected $length;
    protected $start;
    protected $orderValue;
    protected $orderDir;
    protected $column;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function role($role_id)
    {
        $this->role_id = $role_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function Mobile($mobile)
    {
        $this->mobile = $mobile;
    }

    public function email($email)
    {
        $this->email = $email;
    }

    public function gender($gender)
    {
        $this->gender = $gender;
    }

    public function status($status)
    {
        $this->status = $status;
    }

    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }
    public function setDirValue($orderDir)
    {
        $this->orderDir = $orderDir;
    }
    public function setLengthValue($length)
    {
        $this->length = $length;
    }

    public function setStartValue($start)
    {
        $this->start = $start;
    }

    protected function user_get_query()
    {
        if (permission('user-bulk-delet')) {
            $this->column = [null, 'id', null, 'role_id', 'name', 'email', 'mobile_no', 'gender', 'status', null];
        } else {
            $this->column = ['id', null, 'role_id', 'name', 'email', 'mobile_no', 'gender', 'status', null];

        }
        $query =  $this->model->with('role');


        //search Queary
        if (!empty($this->role_id)) {
            $query->where('role_id', $this->role_id);
        }
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }
        if (!empty($this->email)) {
            $query->where('email', 'like', '%' . $this->email . '%');
        }
        if (!empty($this->mobile_no)) {
            $query->where('mobile_no', 'like', '%' . $this->mobile_no . '%');
        }
        if (!empty($this->gender)) {
            $query->where('gender', 'like', '%' . $this->gender . '%');
        }
        if (!empty($this->status)) {
            $query->where('status', 'like', '%' . $this->status . '%');
        }

        //order Query
        if (!empty($this->orderValue && $this->orderDir)) {
            $query->orderBy($this->column[$this->orderValue], $this->orderDir);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    public function dataList()
    {
        $query = $this->user_get_query();

        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }

        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->user_get_query();
        return $query->get()->count();
    }
    public function count_all()
    {
        return $this->model->toBase()->get()->count();
    }
}
