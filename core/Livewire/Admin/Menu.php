<?php

namespace Core\Livewire\Admin;

use Livewire\Component;
use Core\Services\MenuService;

class Menu extends Component
{

    public function contentSelected($content, $pageTitle)
    {
        $this->dispatch('content-selected', content: $content, pageTitle: $pageTitle);
    }
    public function render(MenuService $menu)
    {
        return view('core::admin.livewire.menu', [
            'menuItems' => $menu->all(),
            'mainItems' => $menu->getByGroup('main'),
            'eshopItems' => $menu->getByGroup('eshop'),
            'cmsItems' => $menu->getByGroup('cms'),
            'settingsItems' => $menu->getByGroup('settings'),
        ]);
    }
}
