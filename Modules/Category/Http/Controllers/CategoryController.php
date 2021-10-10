<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;

use Modules\Category\Entities\Category;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Category\Http\Requests\CatagoryRequest;

class CategoryController extends BaseController
{

    public function __construct(Category $model)
    {
        $this->model = $model;
    }


    public function index()
    {
        if (permission('category-access')) {
            $this->setPageData('Category', 'Category', 'fas fa-th-list');
            return view('category::index');
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

            $this->set_datatable_default_property($request);

            $dataList =  $this->model->get_dataList();
            $data = [];
            $no = 1;

            foreach ($dataList as  $value) {
                $action = '';
                if (permission('category-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('category-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = permission('category-bulk-delete') ? table_checkbox($value->id) :  $row[] = '';
                $row[]   = $no++;
                $row[]   = $value->name;
                $row[]   =  change_status($value->status, $value->id,'category-status') ;
                $row[]   = dropdown_action($action);
                $data[]   = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->recordsTotal(), $this->model->recordsFiltered(), $data);
        }
    }

    public function store_or_update_data(CatagoryRequest $request)
    {
        if ($request->ajax()) {
            if (permission('category-add') || permission('category-edit')) {
            $collection = collect($request->validated());
            $collection = $this->track_data($request->update_id, $collection);
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
        if ($request->ajax()) {
            if (permission('category-edit')) {
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
        if ($request->ajax()) {
            if (permission('category-delete')) {
                $result = $this->model->find($request->id)->delete();
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
        if ($request->ajax()) {
            if (permission('category-bulk-delete')) {
                $result = $this->model->destroy($request->id);
                $output = $this->Bulk_delete_message($result);
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
            if (permission('category-status')) {
                
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
