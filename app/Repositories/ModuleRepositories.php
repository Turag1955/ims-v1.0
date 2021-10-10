<?php

namespace App\Repositories;

use App\Models\Module;
use App\Repositories\BaseRepositories;


class ModuleRepositories extends BaseRepositories
{

    protected $model;

    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    public function moduleList(int $menu_id)
    {
        return $this->model->where(['type' => 2, 'menu_id' => $menu_id])->orderBy('order', 'asc')->get()
            ->nest()
            ->setIndent('--   ')
            ->listsFlattened('module_name');
    }

    public function module_list()
    {
        return $this->model->with('permission', 'submenu')->doesntHave('parent')->orderBy('order', 'asc')->get();
    }

    public function session_module_list()
    {
        return $this->model->doesntHave('parent')
            ->orderBy('order', 'asc')
            ->with('children')
            ->get();
    }
}
