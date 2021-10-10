<?php

namespace App\Http\Controllers;


use App\Services\ModuleServices;
use App\Http\Requests\ModuleRequest;

class ModuleController extends BaseController
{


    public function __construct(ModuleServices $ModuleServices)
    {
        $this->service = $ModuleServices;
    }


    public function index(int $id)
    {
        $this->setPageData('Menu Builder', 'Menu Builder', 'fas fa-th-list');
        $data = $this->service->index($id);
        // dd($data);
        return view('module.index', compact('data'));
    }

    public function create(int $menu)
    {
        $this->setPageData('Menu Builder Add', 'Menu Builder Add', 'fas fa-th-list');
        $data = $this->service->index($menu);
        return view('module.form', compact('data'));
    }

    public function storeOrUpdate(ModuleRequest $request)
    {
        $result = $this->service->storeOrUpdate($request);
        if ($result) {
            if ($request->update_id) {
                session()->flash('success', 'Module Update successfully');
            } else {
                session()->flash('success', 'Module add successfully');
            }
            return redirect('menu/builder/' . $request->menu_id);
        } else {
            if ($request->update_id) {
                session()->flash('error', 'Module Update unsuccessfully');
            } else {
                session()->flash('error', 'Module add unsuccessfully');
            }
            return back();
        }
    }


    public function edit(int $menu, int $module)
    {
        $this->setPageData('Menu Builder Update', 'Menu Builder Update', 'fas fa-th-list');
        $data = $this->service->edit($menu, $module);
        return view('module.form', compact('data'));
    }

    public function delete($module)
    {
        $result = $this->service->delete($module);
        if ($result) {
            session()->flash('success', 'Module delete successfully');
            return back();
        } else {
            session()->flash('error', 'Module delete unsuccessfully');
            return back();
        }
    }
}
