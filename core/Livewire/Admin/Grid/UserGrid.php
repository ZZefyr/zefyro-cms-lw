<?php

namespace Core\Livewire\Admin\Grid;

use Core\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class UserGrid extends PowerGridComponent
{

    public string $tableName = 'user-grid-table';

    // ✅ Nové API - bez Header::make()
    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->includeViewOnTop('core::admin.components.user-grid-header'), // ✅ Tlačítko "Přidat uživatele"


            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    #[On('refreshUserGrid')]
    public function refresh(): void
    {
        // Komponenta se automaticky re-renderuje
    }

    public function datasource(): Builder
    {
        return User::query()
            ->with('roles');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('email')
            ->add('roles', function ($user) {
                // ✅ Zobrazení rolí (můžeš upravit dle potřeby)
                return $user->roles->pluck('name')->join(', ');
                // Nebo jen první role: return $user->roles->first()?->name ?? '-';
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Jméno', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'roles')
                ->sortable()
                ->searchable(),

            Column::make('Vytvořeno', 'created_at')
                ->sortable(),

            Column::action('Akce') // ✅ Sloupec pro akce

        ];
    }

    // ✅ Definice tlačítek pro každý řádek
    public function actions(User $row): array
    {
        return [
            Button::add('edit')
                ->slot('Upravit')
                ->class('btn btn-sm btn-primary')
                ->dispatch('edit-user-modal', ['userId' => $row->id]),

            Button::add('delete')
                ->slot('Smazat')
                ->class('btn btn-sm btn-danger')
                ->dispatch('deleteUser', ['userId' => $row->id])
                ->confirm('Opravdu chcete smazat uživatele ' . $row->name . '?'),
        ];
    }

    public function add() {
        $this->dispatch('showCreateUserModal');
    }

    // ✅ Listener pro smazání
    public function deleteUser(int $userId): void
    {
        User::findOrFail($userId)->delete();

        $this->dispatch('notify', [
            'message' => 'Uživatel byl úspěšně smazán',
            'type' => 'success'
        ]);
    }
}
