<?php

namespace Modules\Product\Http\Controllers;


use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;
use keygen;
use Keygen\Keygen as KeygenKeygen;
use Modules\Category\Entities\Category;
use Modules\System\Entities\Brand;
use Modules\System\Entities\Tax;
use Modules\System\Entities\unit;

class ProductController extends BaseController
{
    use UploadAble;


    public function __construct(Product $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if (permission('product-access')) {
            $this->setPageData('Manage Product', 'Manage Product', 'fas fa-box');
            $data = [
                'brands'    => Brand::where('status', '1')->get(),
                'categories' => Category::where('status', '1')->get(),
                'units' => Unit::where('status', '1')->get(),
                'taxes' => Tax::where('status', '1')->get(),
            ];
            return view('product::index', $data);
        } else {
            return $this->unauthorized_access();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->name)) {
                $this->model->setName($request->name);
            }
            if (!empty($request->code)) {
                $this->model->setCode($request->code);
            }
            if (!empty($request->brand_id)) {
                $this->model->setBrandId($request->brand_id);
            }
            if (!empty($request->category_id)) {
                $this->model->setCategoryId($request->category_id);
            }
            $this->set_datatable_default_property($request);
            $dataList = $this->model->get_data_table_list();
            $data = [];
            $no = 1;

            foreach ($dataList as $value) {
                $action = '';
                if (permission('product-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('product-show')) {
                    $action .= '<a class="dropdown-item text-primary user_view" data-id="' . $value->id . '" ><i class="fa fa-eye text-primary"></i> View</a>';
                }
                if (permission('product-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row      = [];
                $row[]    = permission('product-bulk-delete') ? table_checkbox($value->id) :  $row[] = '';
                $row[]    = $no++;
                $row[]    = table_image($value->image, PRODUCT_IMAGE_PATH, $value->name);
                $row[]    = $value->name;
                $row[]    = $value->code;
                $row[]    = $value->brand->title;
                $row[]    = $value->category->name;
                $row[]    = $value->unit->unit_name;
                $row[]    = number_format($value->cost, 2);
                $row[]    = number_format($value->price, 2);
                $row[]    = number_format($value->qty, 2);
                $row[]    = $value->alert_qty ? number_format($value->alert_qty, 2) : 0;
                $row[]    = $value->tax->name;
                $row[]    = TAX_METHOD[$value->tax_method];
                $row[]    = change_status($value->status, $value->id, 'product-status');
                $row[]    = dropdown_action($action);
                $data[]   = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalRecords(), $this->model->recordsFilter(), $data);
        } else {
            return response()->json($this->access_blocked());
        }
    }

    public function store_or_update_data(ProductRequest $request)
    {
        if (permission('product-add') && permission('product-edit')) {
            if ($request->ajax()) {
                $collection = collect($request->validated())->except(['image', 'qty', 'qty_alert']);
                $qty = $request->qty ? $request->qty : null;
                $alert_qty = $request->alert_qty ? $request->alert_qty : null;
                $collection = $this->track_data($request->update_id, $collection);
                $image      = $request->old_image;
                if ($request->has('image')) {
                    $image = $this->uploadfile($request->file('image'), PRODUCT_IMAGE_PATH);
                    if (!empty($request->old_image)) {
                        $this->delete_file($request->old_image, PRODUCT_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image', 'qty', 'alert_qty'));
                $result     = $this->model->updateOrInsert(['id' => $request->update_id], $collection->all());
                $output     = $this->store_message($result, $request->update_id);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function edit(Request $request)
    {
        if (permission('product-edit')) {
            if ($request->ajax()) {
                $result = $this->model->findOrFail($request->id);
                $output = $this->data_message($result);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            if (permission('product-show')) {
                $products = $this->model->with('brand','category','unit','tax','purchase_unit','sale_unit')->findOrFail($request->id);
                return view('product::details-view',compact('products'))->render();
            }else{
                $output = $this->access_blocked();
            }
        }else{
            $output = $this->access_blocked();
        }
    }

    public function delete(Request $request)
    {
        // dd($request->all());
        if (permission('product-delete')) {
            if ($request->ajax()) {

                $data = $this->model->find($request->id);
                $image = $data->image;
                $result = $data->delete();
                if ($result) {
                    if (!empty($image)) {
                        $this->delete_file($image, PRODUCT_IMAGE_PATH);
                    }
                }
                $output = $this->delete_message($result);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function bulk_delete(Request $request)
    {
        // dd($request->all());
        if (permission('product-bulk-delete')) {
            if ($request->ajax()) {
                $products = $this->model->toBase()->select('image')->whereIn('id', $request->id)->get();
                $result = $this->model->destroy($request->id);
                if ($result) {
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            if ($product->image != null) {
                                $this->delete_file($product->image, PRODUCT_IMAGE_PATH);
                            }
                        }
                    }
                }
                $output = $this->delete_message($result);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            if (permission('product-status')) {

                $result = $this->model->find($request->id)->update(['status' => $request->status]);
                $output = $this->status_message($result);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function generate_code()
    {
        return KeygenKeygen::numeric(8)->generate();
    }

    public function populate_unit($unit_id)
    {
        $units = unit::where('base_unit', $unit_id)->orWhere('id', $unit_id)->pluck('unit_name', 'id');
        return json_encode($units);
    }

    public function product_autocomplete_search(Request $request)
    {
        if($request->ajax()){
            if(!empty($request->search)){
                $data = $this->model->where('name','like','%'.$request->search.'%')
                                      ->orWhere('code','like','%'.$request->search.'%')
                                      ->get();
                $output = [];
                
                if(!empty($data)){
                    foreach ($data as $value) {
                       $item['id'] = $value->id;
                       $item['value'] = $value->name.'-'.$value->code;
                       $item['label'] = $value->name.'-'.$value->code;
                       $output[] = $item;
                    }
                }else{
                    $output['value'] = '';
                    $output['label'] = 'No Data Found';
                } 
                echo json_encode($output);              
            }
        }
    }
}
