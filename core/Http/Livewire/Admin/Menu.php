<?php

namespace Core\Http\Livewire\Admin;

use Livewire\Component;

class Menu extends Component
{

    public function contentSelected($content, $pageTitle)
    {
        $this->dispatch('content-selected', content: $content, pageTitle: $pageTitle);
    }
    public function render()
    {
        return view('core::admin.livewire.menu');
    }
}
