<?php

namespace Core\Livewire\Admin\Grids;

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
                ->searchable()
                ->editOnClick(),


            Column::make('Email', 'email')
                ->sortable()
                ->searchable()
                ->editOnClick(),

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
                ->slot('✏️')
                ->class('px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2')
                ->dispatch('edit-user-modal', ['userId' => $row->id]),

            Button::add('delete')
                ->slot('🗑️')
                ->class('px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2')
                ->dispatch('delete-user', ['userId' => $row->id])
                ->confirm('Opravdu chcete smazat uživatele ' . $row->name . '?'),
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        try {
            User::query()->find($id)->update([
                $field => $value,
            ]);

            $this->dispatch('notify', [
                'message' => 'Změna byla úspěšně uložena',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Chyba: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
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
