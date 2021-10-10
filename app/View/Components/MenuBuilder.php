<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuBuilder extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $menuItem;
    public function __construct($menuItem)
    {
        $this->menuItem = $menuItem;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu-builder');
    }
}
