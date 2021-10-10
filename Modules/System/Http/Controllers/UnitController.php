<?php

namespace Modules\System\Http\Controllers;


use Illuminate\Http\Request;
use Modules\System\Entities\Unit;
use Modules\System\Http\Requests\UnitRequest;
use Modules\Base\Http\Controllers\BaseController;


class UnitController extends BaseController
{
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if (permission('unit-access')) {
            $this->setPageData('Unit', 'Unit', 'fas fa-user-friends');
             return view('system::unit.index');
        } else {
            return $this->access_blocked();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->unit_name)) {
                $this->model->setUnitName($request->unit_name);
            }

            $this->set_datatable_default_property($request);
            $dataList = $this->model->get_dataTable();

            $data = [];
            $no = 1;
            foreach ($dataList as  $value) {
                $action = '';
                if (permission('unit-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('unit-show')) {
                    $action .= '<a class="dropdown-item text-primary user_show" data-name="' . $value->unit_name . '" data-id="' . $value->id . '" ><i class="fa fa-eye text-primary"></i> View</a>';
                }
                if (permission('unit-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->unit_name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = table_checkbox($value->id);
                $row[]   = $no++;

                $row[]   = $value->unit_code;
                $row[]   = $value->unit_name;
                $row[]   = $value->baseUnit->unit_name;
                $row[]   = $value->operator;
                $row[]   = $value->operation_value;
                $row[]   = change_status($value->status, $value->id, 'unit-status');
                $row[]   = dropdown_action($action);
                $data[]  = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalField(), $this->model->totalFilter(), $data);
        } else {
            return $this->access_blocked();
        }
    }

    public function store_or_update_data(UnitRequest $request)
    {
        if ($request->ajax()) {
            if (permission('unit-add') || permission('unit-edit')) {
                $collection = collect($request->validated())->except('operator', 'operation_value');
                if ($request->operator) {
                    $collection = $collection->merge(['operator' => $request->operator]);
                }
                if ($request->operation_value) {
                    $collection = $collection->merge(['operation_value' => $request->operation_value]);
                }
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
            if (permission('unit-edit')) {
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
            if (permission('unit-delete')) {
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
            if (permission('unit-bulk-delete')) {
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
            if (permission('unit-status')) {

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
    
    public function base_unit(Request $request)
    {
        if ($request->ajax()) {
            $units = $this->model->where(['base_unit'=>null,'status'=>'1'])->get();
            $output = '<option value="">Select Please</option>';
            if(!$units->isEmpty()){
                foreach ($units as $unit) {
                    $output.= '<option value="'.$unit->id.'">'.$unit->unit_name.'('.$unit->unit_code.')'.'</option>';
                }
            }
            return $output;
        }
    }
}
