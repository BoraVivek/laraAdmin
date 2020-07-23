<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardComponent extends Component
{
    public $bgcolor;

    public $icon;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($bgcolor,$icon)
    {
        $this->bgcolor = $bgcolor;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card-component');
    }
}
