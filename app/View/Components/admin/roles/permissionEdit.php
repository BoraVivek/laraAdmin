<?php

namespace App\View\Components\admin\roles;

use App\Role;
use Illuminate\View\Component;

class permissionEdit extends Component
{
    public $name;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$title,$role)
    {
        $this->name = $name;
        $this->title = $title;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.roles.permission-edit');
    }

    public function isChecked($value)
    {
        return $this->role->hasPermissionTo($value);
    }
}
