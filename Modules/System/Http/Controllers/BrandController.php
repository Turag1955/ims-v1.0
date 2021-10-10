<?php

namespace Modules\System\Http\Controllers;

use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\System\Entities\Brand;
use Illuminate\Contracts\Support\Renderable;
use Modules\System\Http\Requests\BrandRequest;
use Modules\Base\Http\Controllers\BaseController;

class BrandController extends BaseController
{
    use UploadAble;


    public function __construct(Brand $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if (permission('brand-access')) {
            $this->setPageData('Brand', 'Brand', 'fas fa-th-list');
            return view('system::brand.index');
        } else {
            return $this->unauthorized_access();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->title)) {
                $this->model->setTitle($request->title);
            }
            $this->set_datatable_default_property($request);
            $dataList = $this->model->get_data_table_list();
            $data = [];
            $no = 1;

            foreach ($dataList as $value) {
                $action = '';
                if (permission('brand-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('brand-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->title . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row      = [];
                $row[]    = permission('brand-bulk-delete') ? table_checkbox($value->id) :  $row[] = '';
                $row[]    = $no++;
                $row[]    = table_image($value->image, BRAND_IMAGE_PATH, $value->title);
                $row[]    = $value->title;
                $row[]    = change_status($value->status, $value->id, 'brand-status');
                $row[]    = dropdown_action($action);
                $data[]   = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalRecords(), $this->model->recordsFilter(), $data);
        } else {
            return response()->json($this->access_blocked());
        }
    }

    public function store_or_update_data(BrandRequest $request)
    {
        if (permission('brand-add') && permission('brand-edit')) {
            if ($request->ajax()) {
                $collection = collect($request->validated())->only('title');
                $collection = $this->track_data($request->update_id, $collection);
                $image      = $request->old_image;
                if ($request->has('image')) {
                    $image = $this->uploadfile($request->file('image'), BRAND_IMAGE_PATH);
                    if (!empty($request->old_image)) {
                        $this->delete_file($request->old_image, BRAND_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image'));
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
        if (permission('brand-edit')) {
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

    public function delete(Request $request)
    {
        // dd($request->all());
        if(permission('brand-delete')){
            if($request->ajax()){
               
                $data = $this->model->find($request->id);
                $image = $data->image;
                $result = $data->delete();
                if($result){
                    if(!empty($image)){
                        $this->delete_file($image,BRAND_IMAGE_PATH);
                    }
                }
                $output = $this->delete_message($result);
                
            }else{
                $output = $this->access_blocked();
            }
        }else{
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function bulk_delete(Request $request)
    {
        // dd($request->all());
        if(permission('brand-bulk-delete')){
            if($request->ajax()){
               $brands = $this->model->toBase()->select('image')->whereIn('id',$request->id)->get();
               $result = $this->model->destroy($request->id);
               if($result){
                   if(!empty($brands)){
                       foreach ($brands as $brand) {
                          if($brand->image != null){
                              $this->delete_file($brand->image,BRAND_IMAGE_PATH);
                          }
                       }
                   }
               }
               $output = $this->delete_message($result);
               
            }else{
                $output = $this->access_blocked();
            }
        }else{
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            if (permission('brand-status')) {
                
                $result = $this->model->find($request->id)->update(['status'=>$request->status]);
                $output = $this->status_message($result);
            } else {
                $output = $this->access_blocked();
            }
        } else {
            $output = $this->access_blocked();
        }
        return response()->json($output);
    }
}
