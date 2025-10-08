<?php

namespace Core\Http\Livewire\Admin;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedContent = null;
    public $pageTitle = 'Dashboard';


    #[Computed]
    public function stats()
    {
        return [
            'users' => 50,
            'orders' => 20,
            'revenue' => 30,
        ];
    }


    #[On('content-selected')]
    public function loadContent($content, $pageTitle): void
    {
        $this->selectedContent = $content;
        $this->pageTitle = $pageTitle;

    }
    #[Layout('core::layouts.admin')]
    public function render()
    {
        return view('core::admin.livewire.dashboard');
    }
}
