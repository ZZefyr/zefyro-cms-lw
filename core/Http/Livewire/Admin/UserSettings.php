<?php

namespace Core\Http\Livewire\Admin;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class UserSettings extends Component
{
    public function render()
    {
        return view('core::admin.livewire.user-settings');
    }
}
