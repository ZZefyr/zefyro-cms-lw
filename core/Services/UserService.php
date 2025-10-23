<?php

namespace Core\Services;

use Core\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserService {
    public function createWithRole(array $data, int $roleId): User {
        return DB::transaction(function () use ($data, $roleId) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole($roleId);
//
//            $this->sendWelcomeEmail($user, $data['password']);
//            $this->logUserCreation($user);
            $this->notifyAdmins($user);

            return $user;
        });
    }

//    private function sendWelcomeEmail(User $user, string $password): void {
//        Mail::to($user->email)->send(new WelcomeEmail($user, $password));
//    }

//    private function logUserCreation(User $user): void {
//        $this->activity()
//            ->performedOn($user)
//            ->log('Uživatel byl vytvořen');
//    }

    private function notifyAdmins(User $user): void {
// Notifikace pro adminy
    }

    public function editWithRole(int $userId, array $validated, int $selectedRoleId) {
        return DB::transaction(function () use ($userId, $validated, $selectedRoleId) {
            $user = User::find($userId);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (isset($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            // Aktualizuj roli uživatele
            $user->roles()->sync([$selectedRoleId]);

            return $user;
        });
    }


}
