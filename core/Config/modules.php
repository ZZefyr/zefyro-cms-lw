<?php
return [
    'cms' => [
        'admin_menu' => [
            ['label' => 'Stránky', 'route' => 'admin.cms.index'],
        ],
    ],
    'eshop' => [
        'admin_menu' => [
            ['label' => 'Produkty', 'route' => 'admin.shop.index'],
            ['label' => 'Objednávky', 'route' => 'admin.shop.orders'],
        ],
    ],
];
