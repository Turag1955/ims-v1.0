<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionServices;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends BaseController
{
    public function __construct(PermissionServices $permission)
    {
        $this->service = $permission;
    }

    public function index()
    {
        $this->setPageData('Permission', 'Permission', 'fas fa-th-list');
        $data['modules'] = $this->service->index();
        return view('permission.index', compact('data'));
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            $output = $this->service->get_data_table($request);
        } else {
            $output = ['status' => 'error', 'message' => 'Unauthorized Access Blocked'];
        }
        echo json_encode($output);
    }

    public function store(PermissionRequest $request)
    {
        if ($request->ajax()) {
            $result = $this->service->store($request);
            if ($result) {
                return $this->response_json('success', 'Data add Successfull', null, 201);
            } else {
                return $this->response_json('error', 'Data add UnSuccessfull', null, 204);
            }
        } else {
            return $this->response_json('error', null, null, 401);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->service->edit($request);
            if ($result) {
                return $this->response_json('success', null, $result, 201);
            } else {
                return $this->response_json('error', null, $result, 204);
            }
        } else {
            return $this->response_json('error', null, null, 401);
        }
    }
    public function update(PermissionUpdateRequest $request)
    {
        if ($request->ajax()) {
            $result = $this->service->update($request);
            if ($result) {
                return $this->response_json('success', 'Data Update Successfull', null, 201);
            } else {
                return $this->response_json('error', 'Data Update UnSuccessfull', null, 204);
            }
        } else {
            return $this->response_json('error', null, null, 401);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->service->delete($request);
            if ($result) {
                return $this->response_json('success', 'Data Delete Successfull', null, 201);
            } else {
                return $this->response_json('error', 'Data Delete UnSuccessfull', null, 204);
            }
        } else {
            return $this->response_json('error', null, null, 401);
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->service->bulk_delete($request);
            if ($result) {
                return $this->response_json('success', 'Data Delete Successfull', null, 201);
            } else {
                return $this->response_json('error', 'Data Delete UnSuccessfull', null, 204);
            }
        } else {
            return $this->response_json('error', null, null, 401);
        }
    }
}
