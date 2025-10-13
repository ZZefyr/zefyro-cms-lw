<?php

namespace Core\Livewire\Admin;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedContent = 'stats';
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

    protected $componentMap = [
        'admin' => 'admin.pages.stats',
        'user' => 'admin.pages.user',
        'stats' => 'admin.pages.stats',
        'orders' => 'admin.pages.orders',
        'products' => 'admin.pages.products',
        'settings' => 'admin.pages.settings',
    ];

    public function getComponentName()
    {
        return $this->componentMap[$this->selectedContent] ?? null;
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
