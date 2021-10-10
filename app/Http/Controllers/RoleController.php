<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleServices;
use Illuminate\Http\Request;

class RoleController extends BaseController
{


    public function __construct(RoleServices $servise)
    {
        $this->service = $servise;
    }

    public function index()
    {
        $this->setPageData('Role', 'Role', 'fas fa-th-list',);
        return view('role.index');
    }

    public function get_data_table(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $output = $this->service->get_data_table($request);
        } else {
            $output = ['status' => 'error', 'message' => 'Unauthorize Access Blocked!'];
        }
        echo json_encode($output);
    }

    public function create()
    {
        $this->setPageData('Add Role', 'Add Role', 'fas fa-th-list',);
        $data['module_list'] = $this->service->module_list();
        return view('role.create', compact('data'));
    }

    public function store_or_update(RoleRequest $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $result = $this->service->store_or_update_data($request);
            if ($result) {
                return $this->response_json($status = 'success', $message = 'Data Has been save Successfully', $data = null, $response_code = 201);
            } else {
                return $this->response_json($status = 'error', $message = 'Data Cannot save', $data = null, $response_code = 204);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function edit(int $id)
    {
        $this->setPageData('Edit Role', 'Edit Role', 'fas fa-th-list',);
        $result = $this->service->edit($id);
        $data['module_list'] = $this->service->module_list();
        return view('role.edit', compact('result', 'data'));
    }

    public function show(int $id)
    {
        $this->setPageData('View Role', 'View Role', 'fas fa-th-list',);
        $result = $this->service->edit($id);
        $data['module_list'] = $this->service->module_list();
        return view('role.view', compact('result', 'data'));
    }

    
    public function delete(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $result = $this->service->delete($request);
            if ($result==2) {
                return $this->response_json($status = 'success', $message = 'Data Has been save Successfully', $data = null, $response_code = 201);
            } elseif($result==3) {
                return $this->response_json($status = 'error', $message = 'Data Cannot save', $data = null, $response_code = 204);
            }else{
                return $this->response_json($status = 'error', $message = 'please this role doesnt delete', $data = null, $response_code = 204);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $result = $this->service->bulk_delete($request);
            if ($result['status'] == 1) {
                return $this->response_json($status = 'success', $message = 'Data Has been delete Successfully', $data = null, $response_code = 201);
            } elseif($result['status'] == 2) {
                return $this->response_json($status = 'error', $message = 'Data Cannot delete', $data = null, $response_code = 204);
            }else{
                return $this->response_json($status = 'error', $message = 'please this role doesnt delete', $data = null, $response_code = 204);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }
}
