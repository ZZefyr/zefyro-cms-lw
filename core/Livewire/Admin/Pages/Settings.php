<?php

namespace Core\Livewire\Admin\Pages;

use Core\Services\UserService;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Settings extends Component
{
    public function render()
    {
        return view('core::admin.livewire.pages.settings');
    }
}
