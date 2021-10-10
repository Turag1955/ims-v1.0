<?php

namespace Modules\System\Http\Controllers;


use Illuminate\Http\Request;
use Modules\System\Entities\Warehouse;
use Modules\Base\Http\Controllers\BaseController;
use Modules\System\Http\Requests\WarehouseRequest;

class WarehouseController extends BaseController
{
    public function __construct(Warehouse $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if (permission('warehouse-access')) {
            $this->setPageData('Warehouse', 'Warehouse', 'fas fa-parcant');
            return view('system::warehouse.index');
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
                if (permission('warehouse-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('warehouse-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = table_checkbox($value->id);
                $row[]   = $no++;
                $row[]   = $value->name;
                $row[]   = $value->email;
                $row[]   = $value->phone;
                $row[]   = $value->address;
                $row[]   = change_status($value->status, $value->id, 'warehouse-status');
                $row[]   = dropdown_action($action);
                $data[]  = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalField(), $this->model->totalFilter(), $data);
        } else {
            return $this->access_blocked();
        }
    }

    public function store_or_update_data(WarehouseRequest $request)
    {
        if ($request->ajax()) {
            if (permission('warehouse-add') || permission('warehouse-edit')) {
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
            if (permission('warehouse-edit')) {
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
            if (permission('warehouse-delete')) {
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
            if (permission('warehouse-bulk-delete')) {
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
            if (permission('warehouse-status')) {

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
