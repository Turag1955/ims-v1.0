<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Services\BaseServices;
use Illuminate\Support\Facades\Session;
use App\Repositories\ModuleRepositories as module;
use App\Repositories\PermissionRepositories as permission;

class PermissionServices extends BaseServices
{
    protected $permission;
    protected $module;


    public function __construct(module $module, permission $permission)
    {
        $this->permission = $permission;
        $this->module     = $module;
    }
    public function index()
    {
        return $this->module->moduleList(1); // backend menu id 1
    }
    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->name);
            if (!empty($request->name)) {
                $this->permission->SetName($request->name);
            }
            if (!empty($request->module_id)) {
                $this->permission->SetModuleId($request->module_id);
            }
            $this->permission->setOrderValue($request->input('order.0.column'));
            $this->permission->setdirValue($request->input('order.0.dir'));
            $this->permission->setLengthValue($request->input('length'));
            $this->permission->setStartValue($request->input('start'));

            $list = $this->permission->get_data_list();
            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;

                $action = '';
                $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';




                $row = [];
                $row[] = table_checkbox($value->id);
                $row[] = $no;
                $row[] = $value->module->module_name;
                $row[] = $value->name;
                $row[] = $value->slug;
                $row[] = dropdown_action($action);
                $data[] = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->permission->count_all(), $this->permission->count_filtered(), $data);
        }
    }

    public function store(Request $request)
    {

        $permission_data = [];
        foreach ($request->permission as $value) {
            $permission_data[] = [
                'module_id' => $request->module_id,
                'name' => $value['name'],
                'slug' => $value['slug'],
                'created_at' => Carbon::now()
            ];
        }
        $result = $this->permission->insert($permission_data);

        if ($result) {
            if (auth()->user()->role_id == 1) {
                $this->session_permission_restore();
            }
        }
        return $result;
    }

    public function edit(Request $request)
    {
        return $this->permission->find($request->id);
    }

    public function update(Request $request)
    {
        $collection = collect($request->validated());
        $updated_at = Carbon::now();
        $collection = $collection->merge(compact('updated_at'));
        $result = $this->permission->update($collection->all(), $request->update_id);

        if ($result) {
            if (auth()->user()->role_id == 1) {
                $this->session_permission_restore();
            }
        }
        return $result;
    }

    public function delete(Request $request)
    {
        $result = $this->permission->delete($request->id);
        if ($result) {
            if (auth()->user()->role_id == 1) {
                $this->session_permission_restore();
            }
        }
        return $result;
    }

    public function bulk_delete(Request $request)
    {
        $result = $this->permission->destroy($request->id);

        if ($result) {
            if (auth()->user()->role_id == 1) {
                $this->session_permission_restore();
            }
        }
        return $result;
    }


    public function session_permission_restore()
    {
        $permissions = $this->permission->session_permission_list();

        $permission = [];

        if (!$permissions->isEmpty()) {

            foreach ($permissions as $value) {
                array_push($permission, $value->slug);
            }

            Session::forget('permission');
            Session::put('permission', $permission);
            return true;
        }
        return false;
    }
}
