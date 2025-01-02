<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class profilebar extends Component
{
    public $profile;

    public function __construct($profile = null)
    {
        $this->profile = $profile ?? ['id' => session('umkmID')];
    }

    public function render(): View|Closure|string
    {
        return view('components.profilebar');
    }
}
