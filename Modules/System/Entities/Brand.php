<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;


class Brand extends BaseModel
{

    protected $title;

    protected $fillable = ['title', 'brand_image', 'status', 'created_by', 'updated_by'];

    public function setTitle($title)
    {
        $this->title = $title;
    }

    protected function get_data_table_query()
    {
        if (permission('brand-bulk-delete')) {
            $this->column_order = [null, 'id', 'title', 'status', null];
        } else {
            $this->column_order = ['id', 'title', 'status', null];
        }

        $query = self::toBase();
        if (!empty($this->title)) {
            $query->where('title', 'like', '%' . $this->title . '%');
        }
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    public function get_data_table_list()
    {
        $query = $this->get_data_table_query();
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function totalRecords()
    {
        return self::toBase()->get()->count();
    }

    public function recordsFilter()
    {
        $query = $this->get_data_table_query();
        return $query->get()->count();
    }
}
