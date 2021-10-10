<?php

namespace App\Services;

use App\Models\module_role;
use App\Models\permission_role;
use App\Repositories\RoleRepositories as Role;
use App\Repositories\ModuleRepositories as Module;

use Illuminate\Http\Request;

class RoleServices extends BaseServices
{
    protected $role;
    protected $module;


    public function __construct(Module $module, Role $role)
    {
        $this->role   = $role;
        $this->module = $module;
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->role_name)) {
                $this->role->SetName($request->role_name);
            }
            $this->role->setOrderValue($request->input('order.0.column'));
            $this->role->setdirValue($request->input('order.0.dir'));
            $this->role->setLengthValue($request->input('length'));
            $this->role->setStartValue($request->input('start'));


            $list = $this->role->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                $action .= '<a href="' . route('role.edit', ['id' => $value->id]) . '" class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                $action .= '<a href="' . route('role.view', ['id' => $value->id]) . '" class="dropdown-item text-success " data-id="' . $value->id . '" ><i class="fa fa-eye text-primary"></i> View</a>';
                if ($value->deletable == 2) {
                    $action .= '<a class="dropdown-item text-success user_delete" data-name="' . $value->role_name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }

                $row = [];
                ($value->deletable == 2) ?  $row[] = table_checkbox($value->id) :  $row[] = '';
                $row[] = $no;
                $row[] = $value->role_name;
                $row[] = DELETABLE[$value->deletable];
                $row[] = dropdown_action($action);
                $data[] = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->role->count_all(), $this->role->count_filtered(), $data);
        }
    }

    public function module_list()
    {
        return $this->module->module_list();
    }

    public function store_or_update_data(Request $request)
    {

        $collection = collect($request->validated());
        // dd($request->all());
        $role =  $this->role->updateOrCreate(['id' => $request->update_id], $collection->all());
        if ($role) {
            $role->module_role()->sync($request->module);
            $role->permission_role()->sync($request->permission);
            return true;
        }
        return false;
    }

    public function edit(int $id)
    {

        $role = $this->role->module_permission_data($id);
        $module_role = [];
        $permission_role = [];

        if (!$role->module_role->isEmpty()) {
            foreach ($role->module_role as $value) {
                array_push($module_role, $value->id);
            }
        }

        if (!$role->permission_role->isEmpty()) {
            foreach ($role->permission_role as $value) {
                array_push($permission_role, $value->id);
            }
        }

        $data = [
            'role'            => $role,
            'module_role'     => $module_role,
            'permission_role' => $permission_role
        ];
        return $data;
    }

    public function delete(Request $request)
    {
        $role = $this->role->module_permission_data($request->id);
        if (!$role->users->isEmpty()) {
            $result = 1;
        } else {
            $delete_module_role = $role->module_role()->detach();
            $delete_permission_role = $role->permission_role()->detach();
            if ($delete_module_role &&  $delete_permission_role) {
                $role->delete();
                $result = 2;
            } else {
                $result = 3;
            }
        }
        return $result;
    }

    public function bulk_delete(Request $request)
    {
        $delete_role = [];
        $undelete_role = [];

        if (!empty($request->id)) {
            foreach ($request->id as  $ids) {
                $role = $this->role->find($ids);
                if (!$role->users->isEmpty()) {
                    array_push($undelete_role, $ids);
                } else {
                    array_push($delete_role, $ids);
                }
            }
            $message = (!empty($undelete_role)) ? 'This rules(' . implode(',', $undelete_role) . ') can\t delete because they are reated many users ' : '';
            if (!empty($delete_role)) {
                $delete_module_role = module_role::whereIn('role_id', $delete_role)->delete();
                $delete_permission_role = permission_role::whereIn('role_id', $delete_role)->delete();

                if ($delete_module_role &&  $delete_permission_role) {
                    $this->role->destroy($delete_role);
                    $result = ['status' => 1, 'message' => $message];
                } else {
                    $result = ['status' => 2, 'message' => $message];
                }
            } else {
                $result = ['status' => 3, 'message' => $message];
            }
            return $result;
        }
    }
}
