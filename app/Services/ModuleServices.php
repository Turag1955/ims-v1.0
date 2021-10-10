<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseServices;
use Illuminate\Support\Facades\Session;
use App\Repositories\MenuRepositories as menu;
use App\Repositories\ModuleRepositories as module;

class ModuleServices extends BaseServices
{
    protected $menu;
    protected $module;


    public function __construct(module $module, menu $menu)
    {
        $this->menu   = $menu;
        $this->module = $module;
    }

    public function index(int $id)
    {
        $data['menu'] = $this->menu->withMenuItem($id);
        return $data;
    }

    public function storeOrUpdate(Request $request)
    {
        $collect = collect($request->validated());
        $menu_id = $request->menu_id;
        $created_at = $updated_at = Carbon::now();
        if ($request->update_id) {
            $collect = $collect->merge(compact('updated_at'));
        } else {
            $collect = $collect->merge(compact('menu_id', 'updated_at'));
        }
        $result = $this->module->updateOrCreate(['id' => $request->update_id], $collect->all());

        if ($result) {
            if (auth()->user()->role_id == 1) {
                $this->session_module_restore();
            }
        }
        return $result;
    }


    public function edit($menu, $module)
    {
        $data['menu'] = $this->menu->withMenuItem($menu);
        $data['module'] = $this->module->findOrFail($module);
        return $data;
    }

    public function delete($module)
    {
        $result = $this->module->delete($module);
        if($result){
            if(auth()->user()->role_id == 1){
                $this->session_module_restore();
            }
        }
        return $result;
    }

    public function session_module_restore()
    {
        $mudules =  $this->module->session_module_list();

        if (!$mudules->isEmpty()) {
            Session::forget('menu');
            Session::put('menu', $mudules);
            return true;
        }
        return false;
    }
}
