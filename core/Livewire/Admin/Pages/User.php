<?php

namespace Core\Livewire\Admin\Pages;

use Core\Services\UserService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class User extends Component
{
    public $showCreateForm = false;
    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordAgain = '';
    public $selectedRole = '';
    public $showPasswordFields = true;
    #[Locked]
    public bool $editMode = false;
    #[Locked]
    public ?int $userId = null;

    // ✅ Property pro role z DB
    public $roles = [];

    public function mount(): void {
        $this->loadRoles();
    }
    #[On('showCreateUserModal')] // ✅ Odchytí event z UserGrid
    public function add(): void {
        $this->showCreateForm = true;
        $this->editMode = false;
        $this->showPasswordFields = true; // Při vytváření nového uživatele zobraz pole pro heslo
        $this->loadRoles(); // Refresh rolí při otevření modalu

    }

    #[On('edit-user-modal')] // ✅ Odchytí event z UserGrid
    public function edit($userId): void {
        $this->showCreateForm = true;
        $this->editMode = true;
        $this->showPasswordFields = false; // Při editaci nemusíme zobrazovat pole pro heslo
        $this->userId = $userId;
        $this->loadRoles(); // Refresh rolí při otevření modalu
        $this->loadData(); // Refresh rolí při otevření modalu
    }


    #[On('delete-user')] // ✅ Odchytí event z UserGrid
    public function delete($userId): void {
        $currentUser = auth()->user();
        if(!$this->authorize('delete users', $currentUser)) {
            session()->flash('error', 'Nemáte oprávnění k odstranění uživatele.');
            return;
        }
        $user = \Core\Models\User::find($userId);
        if ($user) {
            $user->delete();
            session()->flash('message', 'Uživatel byl odstraněn.');
            $this->dispatch('refreshUserGrid');
        } else {
            session()->flash('error', 'Uživatel nebyl nalezen.');
        }
    }




    private function loadRoles(): void
    {
        $this->roles = Role::all();
    }

    private function loadData(): void
    {
        $user = \Core\Models\User::find($this->userId);
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            // Načti roli uživatele (předpokládáme, že má jednu roli)
            $this->selectedRole = $user->roles->first()?->id ?? '';
        }
    }


    public function save(UserService $userService): void {
        $currentUser = auth()->user();
        $rules = [
            'name' => 'required|string|max:255',
            'selectedRole' => 'required|exists:roles,id',
        ];

        if ($this->editMode) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId),
            ];
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:8';
            $rules['passwordAgain'] = 'required|same:password';
        }

        $validated = $this->validate($rules);

        if (!$this->editMode) {
           if(!$this->authorize('create users', $currentUser)) {
               session()->flash('error', 'Nemáte oprávnění k vytvoření uživatele.');
               return;
           }
            $userService->createWithRole($validated, $this->selectedRole);
            session()->flash('message', 'Uživatel byl vytvořen.');
        } else {
            if(!$this->authorize('edit users', $currentUser)) {
                session()->flash('error', 'Nemáte oprávnění k editaci uživatele.');
                return;
            }
            $userService->editWithRole($this->userId, $validated, $this->selectedRole);
            session()->flash('message', 'Uživatel byl upraven.');
        }

        $this->showCreateForm = false;
        $this->reset(['name', 'email', 'password', 'passwordAgain']);
        $this->dispatch('refreshUserGrid');
    }

    public function render()
    {
        return view('core::admin.livewire.pages.user');
    }
}
