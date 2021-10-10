<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Repositories\RoleRepositories;
use App\Repositories\UserRepositories;

class UserServices extends BaseServices
{

    protected $user;
    protected $role;


    public function __construct(RoleRepositories $role, UserRepositories $user)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        return $this->role->roleList();
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->role_id)) {
                $this->user->role($request->role_id);
            }
            if (!empty($request->name)) {
                $this->user->setName($request->name);
            }
            if (!empty($request->mobile_no)) {
                $this->user->Mobile($request->mobile_no);
            }
            if (!empty($request->email)) {
                $this->user->email($request->email);
            }
            if (!empty($request->gender)) {
                $this->user->gender($request->gender);
            }
            if (!empty($request->status)) {
                $this->user->status($request->status);
            }

            $this->user->setOrderValue($request->input('order.0.column'));
            $this->user->setdirValue($request->input('order.0.dir'));
            $this->user->setLengthValue($request->input('length'));
            $this->user->setStartValue($request->input('start'));


            $list = $this->user->dataList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as  $value) {
                $no++;

                $action = '';
                if (permission('user-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('user-show')) {
                    $action .= '<a class="dropdown-item text-success user_show" data-id="' . $value->id . '" ><i class="fa fa-eye text-secondary"></i> View</a>';
                }
                if (permission('user-delete')) {
                    $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                }


                $row = [];
                if (permission('user-bulk-delete')) {
                    $row[] = table_checkbox($value->id);
                } else {
                    $row[] = '';
                }

                $row[] = $no;
                $row[] = $this->avatar($value);
                $row[] = $value->role->role_name;
                $row[] = $value->name;
                $row[] = $value->email;
                $row[] = $value->mobile_no;
                $row[] = $value->gender == 1 ? '<span class="badge badge-warning">Male</span>' : '<span class="badge badge-info">FeMale</span>';
                $row[] = $value->status == 1 ? '<span style="cursor:pointer" class="badge badge-success ' . (permission('user-status') ? 'change_status' : '') . ' "  data-id="' . $value->id . '" data-status="0">Active</span>' : '<span class="badge badge-danger ' . (permission('user-status') ? 'change_status' : '') . '" data-id="' . $value->id . '" data-status="1">DeActive</span>';
                $row[] = dropdown_action($action);
                $data[] = $row;
            }
            return $this->dataTable_draw($request->input('draw'), $this->user->count_all(), $this->user->count_filtered(), $data);
        }
    }

    public function store_or_update_data(Request $request)
    {

        $collection = collect($request->validated())->except(['password', 'confirm_password']);
        // dd($request->all());
        $created_at = $update_at = Carbon::now();
        $created_by = $modified_by = auth()->user()->name;

        if ($request->update_id) {
            $collection = $collection->merge(compact('modified_by', 'update_at'));
        } else {
            $collection = $collection->merge(compact('created_by', 'created_at'));
        }
        if ($request->password) {
            $collection = $collection->merge(with(['password' => $request->password]));
        }
        return $this->user->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            return $this->user->find($request->id);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            return $this->user->delete($request->id);
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            return $this->user->destroy($request->id);
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            return $this->user->find($request->id);
        }
    }

    public function avatar($users)
    {
        if ($users->avatar) {
            return "<img src='storage/" . USER_AVATAR_PATH . $users->avatar . "' alt='$users->name' style='width:60%'>";
        } else {
            return "<img src='images/" . ($users->gender == 1 ? 'male' : 'female') . ".png' style='width:60%'>";
        }
    }
    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            return $this->user->find($request->id)->update(['status' => $request->status]);
        }
    }
}
