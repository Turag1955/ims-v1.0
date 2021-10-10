<?php

namespace Modules\Base\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function setPageData($page_title, $sub_title, $page_icon)
    {
        view()->share([
            'page_title' => $page_title,
            'sub_title'  => $sub_title,
            'page_icon'  => $page_icon
        ]);
    }

    protected function response_json($status)
    {
        
    }

    protected function set_datatable_default_property(Request $request)
    {
        $this->model->setOrderValue($request->input('order.0.column'));
        $this->model->setdirValue($request->input('order.0.dir'));
        $this->model->setLengthValue($request->input('length'));
        $this->model->setStartValue($request->input('start'));
    }

    protected function dataTable_draw($draw, $recordsTotal, $recordsFiltered, $data)
    {
        return array(
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data
        );
    }


    protected function store_message($result, $update_id = null)
    {
        return $result ? ['status' => 'success', 'message' => !empty($update_id) ? 'Data Has Been Updated Successfully' : 'Data Has Been Saved Successfully']
            : ['status' => 'error', 'message' => !empty($update_id) ? 'Failed To Updated Data' : 'Failed To Data Save'];
    }

    protected function delete_message($result)
    {
       return $result ? ['status' => 'success', 'message' => 'Data Has Been Delete Successfully']
            : ['status' => 'error', 'message' => 'Failed To Data Delete'];
    }
    protected function status_message($result)
    {
       return $result ? ['status' => 'success', 'message' => 'Status Has Successfully Change']
            : ['status' => 'error', 'message' => 'Failed To Status Change'];
    }

    protected function Bulk_delete_message($result)
    {
      return  $result ? ['status' => 'success', 'message' => 'Selected Data Has Been Delete Successfully']
                : ['status' => 'error', 'message' => 'Failed To Selected Data Delete'];
    }

    protected function unauthorized_access(){
        return redirect('unauthorized');
     }

     protected function access_blocked()
     {
         return ['status' => 'error','message' => 'Unauthorized Access Blocked'];
     }

     protected function data_message($data)
     {
         return $data ? $data : ['status' => 'error','message' => 'Data Has Not Found'];
     }

     protected function track_data($update_id = null,$collection)
     {
         $created_by = $updated_by = auth()->user()->name;
         $created_at = $updated_at = Carbon::now();

         return $update_id ? $collection->merge(compact('updated_by','updated_at'))
                : $collection->merge(compact('created_by','created_at'));
     }
}
