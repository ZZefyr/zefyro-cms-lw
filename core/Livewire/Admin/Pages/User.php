<?php

namespace Core\Livewire\Admin\Pages;

use Core\Services\UserService;
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


    // ✅ Property pro role z DB
    public $roles = [];

    public function mount(): void {
        $this->loadRoles();
    }
    #[On('showCreateUserModal')] // ✅ Odchytí event z UserGrid
    public function add(): void {
        $this->showCreateForm = true;
        $this->loadRoles(); // Refresh rolí při otevření modalu
    }

    private function loadRoles(): void
    {
        $this->roles = Role::all();
    }


    public function save(UserService $userService): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'passwordAgain' => 'required|same:password',
            'selectedRole' => 'required|exists:roles,id', // ✅ Validace role
        ], [
            'passwordAgain.same' => 'Hesla se neshodují',
            'selectedRole.required' => 'Vyberte roli',
        ]);

        if($this->passwordAgain != $this->password) {
            $this->addError('passwordAgain', 'Hesla se neshodují.');
            return;
        }


        // Vytvoř uživatele
        $user = $userService->createWithRole($validated, $this->selectedRole);

        // Zavři modal
        $this->showCreateForm = false;

        // Reset formuláře
        $this->reset(['name', 'email', 'password']);

        // Notification (volitelné)
        session()->flash('message', 'Uživatel byl úspěšně vytvořen!');

        // Refresh gridu
        $this->dispatch('refreshUserGrid');
    }

    public function render()
    {
        return view('core::admin.livewire.pages.user');
    }
}
