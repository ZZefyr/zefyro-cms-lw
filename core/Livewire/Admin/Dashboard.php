<?php

namespace Core\Livewire\Admin;

use Core\Models\User;
use Core\Services\AdminService;
use Core\Services\MenuService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedContent = 'stats';
    public $pageTitle = 'Dashboard';

    protected AdminService $adminService;

    public function boot(AdminService $adminService): void
    {
        $this->adminService = $adminService;
    }

    public function getComponentName()
    {
        $allowedComponentsMap = $this->adminService->getAllowedContent();
        return $allowedComponentsMap[$this->selectedContent] ?? null;
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
