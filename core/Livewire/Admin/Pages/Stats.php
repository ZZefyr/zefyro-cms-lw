<?php

namespace Core\Livewire\Admin\Pages;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Stats extends Component
{
    #[Computed]
    public function stats()
    {
        return [
            'users' => 50,
            'orders' => 20,
            'revenue' => 30,
        ];
    }

    public function render()
    {
        return view('core::admin.livewire.pages.stats');
    }
}
