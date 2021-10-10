<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Http\Requests\UserRequest;

class UserController extends BaseController
{
    protected $service;

    public function __construct(UserServices $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        if (permission('user-access')) {
            $this->setPageData('User', 'User', 'fas fa-th-list');
            $roles =  $this->service->index();
            return view('user.index', compact('roles'));
        } else {
            return $this->unauthorized_access();
        }
    }

    public function get_data_table(Request $request)
    {
        if (permission('user-access')) {
            if ($request->ajax()) {
                $output = $this->service->get_data_table($request);
            } else {
                $output = ['status' => 'error', 'message' => 'Unauthorize Access Blocked!'];
            }
            echo json_encode($output);
        }
    }

    public function store_or_update(UserRequest $request)
    {
        if ($request->ajax()) {
            if (permission('user-add') || permission('user-edit')) {
                // dd($request->all());
                $result = $this->service->store_or_update_data($request);
                if ($result) {
                    return $this->response_json($status = 'success', $message = 'Data Has been save Successfully', $data = null, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = 'Data Cannot save', $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized access blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            if (permission('user-edit')) {
                // dd($request->all());
                $data = $this->service->edit($request);
                if ($data) {
                    return $this->response_json($status = 'success', $message = null, $data = $data, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = null, $data = $data, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized access blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('user-delete')) {
                // dd($request->all());
                $data = $this->service->delete($request);
                if ($data) {
                    return $this->response_json($status = 'success', $message = "Data Delete Successfully", $data = null, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = "Data Not Delete Successfully", $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized access blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('user-bulk-delete')) {
                // dd($request->all());
                $data = $this->service->bulk_delete($request);
                if ($data) {
                    return $this->response_json($status = 'success', $message = "Data Delete Successfully", $data = null, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = "Data Not Delete Successfully", $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized access blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function show(Request $request)
    {
        if (permission('user-show')) {
            $users =  $this->service->show($request);
            return view('user.user_view', compact('users'))->render();
        } else {
            return $this->unauthorized_access();
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            if (permission('user-status')) {
                // dd($request->all());
                $data = $this->service->change_status($request);
                if ($data) {
                    if ($request->status == 0) {
                        return $this->response_json($status = 'success', $message = "User Deactive", $data = null, $response_code = 201);
                    } else {
                        return $this->response_json($status = 'success', $message = "User Active", $data = null, $response_code = 201);
                    }
                } else {
                    return $this->response_json($status = 'error', $message = "Status Not Change", $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized access blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }
}
