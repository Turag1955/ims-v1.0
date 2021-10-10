<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuServices;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\BaseController;
use App\Services\ModuleServices;

class MenuController extends BaseController
{
    protected $service;
    protected $module;


    public function __construct(MenuServices $service,ModuleServices $module)
    {
        $this->service = $service;
        $this->module = $module;

    }


    public function index()
    {
        if (permission('menu-access')) {
            $this->setPageData('menu', 'menu', 'fas fa-th-list');
            return view('menu.index');
        } else {
            return $this->unauthorized_access();
        }
    }

    public function get_data_table(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            if (permission('menu-access')) {
                $output = $this->service->get_data_table($request);
            } else {
                $output = ['status' => 'error', 'message' => 'Unauthorize Access Blocked!'];
            }
            echo json_encode($output);
        }
    }

    public function store_or_update_data(MenuRequest $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            if (permission('menu-add') || permission('menu-edit')) {
                $result = $this->service->store_or_update_data($request);
                if ($result) {
                    return $this->response_json($status = 'success', $message = 'Data Has been save Successfully', $data = null, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = 'Data Cannot save', $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized Access Blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            if (permission('menu-edit')) {
                $data = $this->service->edit($request);
                if ($data) {
                    return $this->response_json($status = 'success', $message = null, $data = $data, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = 'No Data Found', $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized Access Blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('menu-delete')) {
                $result = $this->service->delete($request);
                if ($result) {
                    return  $this->response_json($status = 'success', $message = 'Data Has been Deleted Successfully', $data = null, $response_code = 201);
                } else {
                    return  $this->response_json($status = 'error', $message = 'Data Cannot Delete', $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized Access Blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('menu-bulk-delete')) {
                $result = $this->service->bulk_delete($request);
                if ($result) {
                    return $this->response_json($status = 'success', $message = 'Data Has been Deleted Successfully', $data = null, $response_code = 201);
                } else {
                    return $this->response_json($status = 'error', $message = 'No Cannot Delete', $data = null, $response_code = 204);
                }
            } else {
                return $this->response_json($status = 'error', $message = 'Unauthorized Access Blocked', $data = null, $response_code = 401);
            }
        } else {
            return $this->response_json($status = 'error', $message = null, $data = null, $response_code = 401);
        }
    }

    public function orderItem(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));
        $this->service->orderMenu($menuItemOrder, null);
        $this->module->session_module_restore();
    }
}
