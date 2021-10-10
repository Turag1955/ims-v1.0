<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\BaseServices;
use App\Repositories\MenuRepositories as menu;
use App\Repositories\ModuleRepositories as module;

use Carbon\Carbon;


class MenuServices extends BaseServices
{
    protected $menu;
    protected $module;


    public function __construct(module $Module, menu $menu)
    {
        $this->menu   = $menu;
        $this->module = $Module;
    }

    public function get_data_table(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->menu_name)) {
                $this->menu->setMenuName($request->menu_name);
            }


            $this->menu->setOrderValue($request->input('order.0.column'));
            $this->menu->setdirValue($request->input('order.0.dir'));
            $this->menu->setLengthValue($request->input('length'));
            $this->menu->setStartValue($request->input('start'));

            $list = $this->menu->getDataTableList();
            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if (permission('menu-edit')) {
                    $action .= '<a class="dropdown-item text-success user_edit" data-id="' . $value->id . '" ><i class="fa fa-pen text-secondary"></i> Edit</a>';
                }
                if (permission('menu-builder-access')) {
                    $action .= '<a href="' . route('menu.builder', ['id' => $value->id]) . '" class="dropdown-item text-primary " data-id="' . $value->id . '" ><i class="fas fa-list text-primary"></i> Buillder</a>';
                }
                if (permission('menu-delete')) {
                    if ($value->deletable == 2) {
                        $action .= '<a class="dropdown-item text-danger user_delete" data-name="' . $value->menu_name . '"  data-id="' . $value->id . '" ><i class="fa fa-trash text-danger"></i> Delete</a>';
                    }
                }
                $row = [];
                if (permission('menu-bulk-delete')) {
                    ($value->deletable == 2) ?  $row[] = table_checkbox($value->id) :  $row[] = '';
                }
                $row[] = $no;
                $row[] = $value->menu_name;
                $row[] = DELETABLE[$value->deletable];
                $row[] = dropdown_action($action);
                $data[] = $row;
            }

            return $this->dataTable_draw($request->input('draw'), $this->menu->count_all(), $this->menu->count_filtered(), $data);
        }
    }
    public function store_or_update_data(Request $request)
    {

        $collection = collect($request->validated());
        // dd($request->all());
        $created_at = $update_at = Carbon::now();
        if ($request->update_id) {
            $collection = $collection->merge(compact('update_at'));
        } else {
            $collection = $collection->merge(compact('created_at'));
        }
        //dd($collection->all());
        return $this->menu->updateOrCreate(['id' => $request->update_id], $collection->all());
    }
    public function edit(Request $request)
    {
        return $this->menu->find($request->id);
    }

    public function delete(Request $request)
    {
        return $this->menu->delete($request->id);
    }

    public function bulk_delete(Request $request)
    {
        return $this->menu->destroy($request->id);
    }

    public function orderMenu(array $menuItems, $parent_id)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = $this->module->findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parent_id;
            $item->save();
            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}
