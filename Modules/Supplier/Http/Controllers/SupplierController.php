<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Supplier\Entities\Supplier;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Supplier\Http\Requests\SupplierRequest;

class SupplierController extends BaseController
{
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if (permission('supplier-access')) {
            $this->setPageData('Supplier', 'Supplier', 'fas fa-user-tie');
            return view('supplier::index');
        } else {
            return $this->access_blocked();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->name)) {
                $this->model->setName($request->name);
            }
            if (!empty($request->email)) {
                $this->model->setEmail($request->email);
            }
            if (!empty($request->phone)) {
                $this->model->setPhone($request->phone);
            }
            $this->set_datatable_default_property($request);
            $dataList = $this->model->get_dataTable();

            $data = [];
            $no = 1;
            foreach ($dataList as  $value) {
                $action = '';
                if (permission('supplier-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('supplier-show')) {
                    $action .= '<a class="dropdown-item text-primary user_show" data-name="' . $value->name . '" data-id="' . $value->id . '" ><i class="fa fa-eye text-primary"></i> View</a>';
                }
                if (permission('supplier-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = table_checkbox($value->id);
                $row[]   = $no++;
                $row[]   = $value->name;
                $row[]   = $value->email;
                $row[]   = $value->phone;
                $row[]   = $value->company_name;
                $row[]   = $value->vat_number;
                $row[]   = $value->city;
                $row[]   = $value->postal_code;
                $row[]   = $value->country;
                $row[]   = change_status($value->status, $value->id, 'supplier-status');
                $row[]   = dropdown_action($action);
                $data[]  = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalField(), $this->model->totalFilter(), $data);
        } else {
            return $this->access_blocked();
        }
    }

    public function store_or_update_data(SupplierRequest $request)
    {
        if ($request->ajax()) {
            if (permission('supplier-add') || permission('supplier-edit')) {
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
            if (permission('supplier-edit')) {
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
            if (permission('supplier-delete')) {
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

    public function show(Request $request)
    {
        if ($request->ajax()) {
            if (permission('supplier-show')) {
                $result = $this->model->find($request->id);
               return view('supplier::show-details',compact('result'))->render();
            } else {
                $output = $this->access_blocked();
                response()->json($output);
            }
        } else {
            $output = $this->access_blocked();
            response()->json($output);
        }
       
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('supplier-bulk-delete')) {
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
            if (permission('supplier-status')) {

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
}
