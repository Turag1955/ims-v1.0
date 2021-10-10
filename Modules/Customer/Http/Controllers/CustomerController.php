<?php

namespace Modules\Customer\Http\Controllers;


use Illuminate\Http\Request;

use Modules\Customer\Entities\Customer;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Customer\Http\Requests\CustomerRequest;
use Modules\System\Entities\CustomerGroup;

class CustomerController extends BaseController
{
    protected $CustomerGroup;
    public function __construct(CustomerGroup $CustomerGroup,Customer $model)
    {
        $this->model = $model;
        $this->CustomerGroup = $CustomerGroup;
        
    }
    public function index()
    {
        if (permission('customer-access')) {
            $this->setPageData('Customer', 'Customer', 'fas fa-user-friends');
            $customer_group =  $this->CustomerGroup->statusFun();
        //    dd($customer_group);
            return view('customer::index', compact('customer_group'));
        } else {
            return $this->access_blocked();
        }
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->customer_group_id)) {
                $this->model->setCustomerGroupId($request->customer_group_id);
            }
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
                if (permission('customer-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('customer-show')) {
                    $action .= '<a class="dropdown-item text-primary user_show" data-name="' . $value->name . '" data-id="' . $value->id . '" ><i class="fa fa-eye text-primary"></i> View</a>';
                }
                if (permission('customer-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }
                $row       = [];
                $row[]   = table_checkbox($value->id);
                $row[]   = $no++;
                $row[]   = $value->customer_group->group_name;
                $row[]   = $value->name;
                $row[]   = $value->email;
                $row[]   = $value->phone;
                $row[]   = $value->company_name;
                $row[]   = $value->tax_number;
                $row[]   = $value->city;
                $row[]   = $value->postal_code;
                $row[]   = $value->country;
                $row[]   = change_status($value->status, $value->id, 'customer-status');
                $row[]   = dropdown_action($action);
                $data[]  = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->model->totalField(), $this->model->totalFilter(), $data);
        } else {
            return $this->access_blocked();
        }
    }

    public function store_or_update_data(CustomerRequest $request)
    {
        if ($request->ajax()) {
            if (permission('customer-add') || permission('customer-edit')) {
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
            if (permission('customer-edit')) {
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
            if (permission('customer-delete')) {
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
            if (permission('customer-show')) {
                $result = $this->model->with('customer_group')->find($request->id);
                return view('customer::show-details', compact('result'))->render();
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
            if (permission('customer-bulk-delete')) {
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
            if (permission('customer-status')) {

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
