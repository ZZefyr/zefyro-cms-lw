<?php

namespace Core\Livewire\Admin\Components;

use Core\Services\MenuService;
use Livewire\Component;

class Menu extends Component
{

    public function contentSelected($content, $pageTitle)
    {
        $this->dispatch('content-selected', content: $content, pageTitle: $pageTitle);
    }
    public function render(MenuService $menu)
    {
        return view('core::admin.livewire.components.menu', [
            'menuItems' => $menu->all(),
            'mainItems' => $menu->getByGroup('main'),
            'eshopItems' => $menu->getByGroup('eshop'),
            'cmsItems' => $menu->getByGroup('cms'),
            'settingsItems' => $menu->getByGroup('settings'),
        ]);
    }
}
