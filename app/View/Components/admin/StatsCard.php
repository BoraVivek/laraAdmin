<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class StatsCard extends Component
{
    public $stats;
    public $icon;
    public $url;
    // public $arrowcolor;
    // public $since;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($stats, $icon, $url)
    {
        $this->icon = $icon;
        // $this->bgcolor = $bgcolor;
        $this->stats = $stats;
        $this->url = $url;
        // $this->since = $since;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.stats-card');
    }
}
