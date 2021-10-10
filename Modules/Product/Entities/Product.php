<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\Category\Entities\Category;
use Modules\System\Entities\Brand;
use Modules\System\Entities\Tax;
use Modules\System\Entities\unit;

class Product extends BaseModel
{

    protected $name;
    protected $code;
    protected $category_id;
    protected $brand_id;

    protected $fillable = [
        'name', 'code', 'barcode_symbology', 'image', 'brand_id', 'category_id', 'unit_id', 'purchase_unit_id',
        'sale_unit_id', 'cost', 'price', 'qty', 'alert_qty', 'tax_id', 'tax_method', 'description', 'status',
        'created_by', 'updated_by'
    ];
    /***********
      Relationship
     *********/
    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault(['title' => 'None Brand']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class)->withDefault(['name'=>'None Tax']);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchase_unit()
    {
        return $this->belongsTo(unit::class,'purchase_unit_id','id');
    }
    
    public function sale_unit()
    {
        return $this->belongsTo(unit::class,'sale_unit_id','id');
    }
    /***********
      End Relationship
     *********/

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setBrandId($brand_id)
    {
        $this->categobrand_idry_id = $brand_id;
    }

    protected function get_data_table_query()
    {
        if (permission('product-bulk-delete')) {
            $this->column_order = [
                null, 'id', 'image', 'name', 'code', 'brand_id', 'category_id', 'unit_id',
                'cost', 'price', 'qty', 'alert_qty', 'tax_id', 'tax_method', 'status', null
            ];
        } else {
            $this->column_order = [
                'id', 'image', 'name', 'code', 'brand_id', 'category_id', 'unit_id',
                'cost', 'price', 'qty', 'alert_qty', 'tax_id', 'tax_method', 'status', null
            ];
        }

        $query = self::with('brand','category','unit','tax','purchase_unit','sale_unit');

        /***********
         * search Query
         ************/
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }
        if (!empty($this->code)) {
            $query->where('code', 'like', '%' . $this->code . '%');
        }
        if (!empty($this->brand_id)) {
            $query->where('brand_id', $this->brand_id);
        }
        if (!empty($this->category_id)) {
            $query->where('category_id', $this->category_id);
        }

        /***********
         * End search Query
         ************/

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
