<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CMS - Obecné nastavení
    |--------------------------------------------------------------------------
    |
    | Konfigurace pro modul CMS (správa stránek, kategorií, médií atd.).
    | Každá hodnota se dá přepsat v hlavní aplikaci vytvořením
    | souboru config/cms.php s vlastním obsahem.
    |
    */

    'name' => 'Eshop Modul',

    'enabled' => true, // umožní vypnout celý modul

    /*
    |--------------------------------------------------------------------------
    | Routy a URL prefixy
    |--------------------------------------------------------------------------
    */
    'routes' => [
        'prefix' => 'admin/eshop',
        'middleware' => ['web', 'auth', 'admin'], // middleware stack
    ],

    /*
    |--------------------------------------------------------------------------
    | Výchozí nastavení pro stránky
    |--------------------------------------------------------------------------
    */
    'pages' => [
        'default_status' => 'draft', // nebo 'published'
        'allowed_statuses' => ['draft', 'published', 'archived'],

        'default_template' => 'default',
        'templates' => [
            'default' => 'Základní stránka',
            'homepage' => 'Domovská stránka',
            'contact' => 'Kontaktní stránka',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Média
    |--------------------------------------------------------------------------
    */
    'media' => [
        'storage_disk' => 'public', // nebo 's3' apod.
        'upload_path' => 'uploads/eshop',
        'max_file_size' => 5 * 1024, // 5 MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Role a oprávnění
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'manage_pages' => 'Spravovat stránky',
        'manage_categories' => 'Spravovat kategorie',
        'manage_media' => 'Spravovat média',
    ],

    /*
    |--------------------------------------------------------------------------
    | Název view layoutu
    |--------------------------------------------------------------------------
    | Umožní změnit, jaký layout se používá pro CMS sekci.
    */
    'layout' => 'eshop::admin.layout',
];
