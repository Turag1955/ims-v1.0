<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\System\Entities\CustomerGroup;
use Modules\System\Http\Requests\CustomerGroupRequest;

class CustomerGroupController extends BaseController
{
    public function __construct(CustomerGroup $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        if (permission('customer-group-access')) {
            $this->setPageData('CustomerGroup', 'CustomerGroup', 'fas fa-user-friends');
            return view('system::customer-group.index');
        } else {
            return $this->access_blocked();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->group_name)) {
                $this->model->setName($request->group_name);
            }
            $this->set_datatable_default_property($request);
            $dataList = $this->model->get_dataTable();
            $data = [];
            $no = 1;
            foreach ($dataList as  $value) {
                $action = '';
                if (permission('customer-group-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('customer-group-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->group_name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = table_checkbox($value->id);
                $row[]   = $no++;
                $row[]   = $value->group_name;
                $row[]   = $value->parcentage;
                $row[]   = change_status($value->status, $value->id, 'customer-group-status');
                $row[]   = dropdown_action($action);
                $data[]   = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalField(), $this->model->totalFilter(), $data);
        } else {
            return $this->access_blocked();
        }
    }

    public function store_or_update_data(CustomerGroupRequest $request)
    {
        if ($request->ajax()) {
            if (permission('customer-group-add') || permission('customer-group-edit')) {
                $collection = collect($request->validated());
            

                $parcentage = $request->parcentage ? $request->parcentage : null;
                $collection = $collection->merge(compact('parcentage'));
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
            if (permission('customer-group-edit')) {
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
            if (permission('customer-group-delete')) {
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
            if (permission('customer-group-bulk-delete')) {
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
            if (permission('customer-group-status')) {

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
