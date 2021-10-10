<?php

namespace Modules\Product\Http\Controllers;



use Modules\Product\Entities\Product;
use Modules\Base\Http\Controllers\BaseController;

use Modules\Product\Http\Requests\BarcodeRequest;


class BarcodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    public function index()
    {
        if (permission('print-barcode-access')) {
            $this->setPageData('Print Barcode','Print Barcode','fas fa-barcode');
            $products = $this->model->all();
            return view('product::barcode.index',compact('products'));
        } else {
            response()->json($this->unauthorized_access());
        }
    }


    public function generate_barcode(BarcodeRequest $request)
    {
       if($request->ajax()){
          $data = collect($request->all());
          return view('product::barcode.barcode',compact('data'))->render();
       }
    }
}
