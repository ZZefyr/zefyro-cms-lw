<?php

namespace Modules\Cms\Livewire\Admin\Pages;

use Livewire\Attributes\Computed;
use Livewire\Component;

class PageList extends Component
{

    public function render()
    {
        return view('cms::admin.livewire.pages.page-list');
    }
}
