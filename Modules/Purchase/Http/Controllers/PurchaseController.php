<?php

namespace Modules\Purchase\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Purchase\Entities\Purchase;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Supplier\Entities\Supplier;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Warehouse;

class PurchaseController extends BaseController
{
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (permission('purchase-access')) {
            $this->setPageData('Purchase', 'Purchase', 'fas fa-box');
            return view('purchase::index');
        } else {
            return $this->unauthorized_access();
        }
    }

    public function create()
    {
        if (permission('purchase-access')) {
            $this->setPageData('Add Purchase', 'Add Purchase', 'fas fa-plus-square');
            $data = [
                'suppliers'  => Supplier::where('status', 1)->get(),
                'warehouses' => Warehouse::where('status', 1)->get(),
                'taxes'      => Tax::where('status', 1)->get()
            ];
            return view('purchase::create', $data);
        } else {
            return $this->unauthorized_access();
        }
    }
}
